<?php


namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected function homePageRoute()
    {
        return '/dashboard';
    }

    protected function loginRoute()
    {
        return route('login');
    }

    protected function logoutRoute()
    {
        return route('logout');
    }

    protected function getTooManyLoginAttemptsMessage()
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    public function testUserCanViewALoginForm()
    {
        $response = $this->get($this->loginRoute());

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get($this->loginRoute());

        $response->assertRedirect('/dashboard');
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $password = 'lypa-i-pypa';

        $user = factory(User::class)->create([
            'password' => \Hash::make($password),
        ]);
        $user->save();

        \Session::start();

        $response = $this->post('/login', [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

    }

    public function testRememberMeFunctionality()
    {
        $password = 'lypa-i-pypa';

        $user = factory(User::class)->create([
            'password' => \Hash::make($password),
        ]);

        \Session::start();

        $response = $this->post($this->loginRoute(), [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $user = $user->fresh();

        $response->assertRedirect($this->homePageRoute());
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->_id,
            $user->remember_token,
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $password = 'lypa-i-pypa';

        $user = factory(User::class)->create([
            'password' => $password,
        ]);

        \Session::start();

        $response = $this->from($this->loginRoute())->post($this->loginRoute(), [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotLoginWithEmailThatDoesNotExist()
    {
        \Session::start();

        $response = $this->from($this->loginRoute())->post($this->loginRoute(), [
            '_token' => csrf_token(),
            'email' => 'email@email.email',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $response = $this->get($this->logoutRoute());
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute()
    {
        $password = 'lypa-i-pypa';

        \Session::start();

        $user = factory(User::class)->create([
            '_token' => csrf_token(),
            'password' => \Hash::make($password),
        ]);

        foreach (range(0, 5) as $_) {
            $response = $this->from($this->loginRoute())->post($this->loginRoute(), [
                '_token' => csrf_token(),
                'email' => $user->email,
                'password' => 'invalid-password',
            ]);
        }

        $response->assertRedirect($this->loginRoute());
        $response->assertSessionHasErrors('email');
        $this->assertRegExp(
            $this->getTooManyLoginAttemptsMessage(),
            collect(
                $response
                    ->baseResponse
                    ->getSession()
                    ->get('errors')
                    ->getBag('default')
                    ->get('email')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
