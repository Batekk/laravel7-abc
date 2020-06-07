<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash};

class UserController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('users.show', compact('users'));
    }

    public function userCreate()
    {
        $user = [];
        return view('users.createEdit', compact('user'));
    }

    public function userStore(Request $request)
    {
        $password = Helper::generateRandomString(12);

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($password)
        ]);

        $user->save();
        return redirect(route('users.show'))->with('password', $password);
    }

    public function userEdit($id)
    {
        $user = User::where('_id', $id)->firstOrFail();
        return view('users.createEdit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::where('_id', $id)->firstOrFail();
        $user->update($request->all());
        return redirect(route('users.show'));
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.show')
            ->with('password', 'Удален');
    }
}
