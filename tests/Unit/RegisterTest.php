<?php


namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    protected function homePageRoute()
    {
        return '/dashboard';
    }

    protected function registerRoute()
    {
        return 'register';
    }

    public function testUserCanViewARegistrationForm()
    {
        $response = $this->get($this->registerRoute());

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }


    public function testUserCannotViewARegistrationFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get($this->registerRoute());

        $response->assertRedirect($this->homePageRoute());
    }

    /**
     *  Если после повторного теста выпадает ошибка,
     *  то закомментировать App\Http\Controllers\Auth\RegisterController
     */
    public function testUserCanRegister()
    {
        $name = 'UserTestRegister';
        $email = 'user@gmail.com';
        $password = 'password_test';

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user = User::where('email', $email)->first();

        $response->assertRedirect($this->homePageRoute());

        $this->assertAuthenticatedAs($user);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);

        $user->delete();
    }

    public function testUserCannotRegisterWithoutEmail()
    {
        $name = 'UserTestRegister';
        $email = '';
        $password = 'password_test';

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'first_name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        $response->assertRedirect($this->registerRoute());
        $response->assertSessionHasErrors('email');

        $user = User::where('name', 'UserTestRegister')->get();
        $this->assertCount(0, $user);
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithInvalidEmail()
    {
        $first_name = 'UserTestRegister';
        $email = 'invalid-email';
        $password = 'password_test';;

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'first_name' => $first_name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user = User::where('first_name', 'UserTestRegister')->get();

        $this->assertCount(0, $user);
        $response->assertRedirect($this->registerRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutPassword()
    {
        $first_name = 'UserTestRegister';
        $email = 'user@test.com';
        $password = '';

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'first_name' => $first_name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user = User::where('first_name', 'UserTestRegister')->get();

        $this->assertCount(0, $user);
        $response->assertRedirect($this->registerRoute());
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutPasswordConfirmation()
    {
        $first_name = 'UserTestRegister';
        $email = 'user@test.com';
        $password = 'lypa-i-pypa';

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'first_name' => $first_name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => 'o_O',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('password');

        $user = User::where('email', $email)->get();
        $this->assertCount(0, $user);


        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithPasswordsNotMatching()
    {
        $first_name = 'UserTestRegister';
        $email = 'user@test.com';
        $password = 'password_test';

        \Session::start();

        $response = $this->from($this->registerRoute())->post($this->registerRoute(), [
            '_token' => csrf_token(),
            'first_name' => $first_name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => 'o_O',
        ]);

        $response->assertRedirect($this->registerRoute());
        $response->assertSessionHasErrors('password');

        $user = User::where('first_name', 'UserTestRegister')->get();

        $this->assertCount(0, $user);
        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
