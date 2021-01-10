<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return Factory|JsonResponse|View
     */
    public function index(User $user)
    {
        if (request()->ajax()) {
            return $user::dataTable()->toJson();
        }

        return view('layouts.dataTable.index', [
            'html' => $user->html(),
            'breadcrumb' => 'Пользователи',
            'url_create' => route('users.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function create(User $user)
    {
        return view('users.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        User::create($request->input());
        return redirect(route('users.index'))->with('success', 'Успех');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        return view('users.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->input());
        return redirect(route('users.index'))->with('success', 'Обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('alert', 'Удален');
    }

    /* Авторизация под пользователем */
    public function login(User $user)
    {
        Auth::login($user);
        return redirect(route('dashboard'))->with('success', 'Выполнен вход под пользователем');
    }
}
