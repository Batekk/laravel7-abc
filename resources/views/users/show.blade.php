@extends('layouts.app')

@section('content')
    <div class="card col-6">
        <div class="card-header">
            Пользователи
        </div>
        <div class="card-body">
            @if (session('password'))
                <br>
                <div class="alert alert-primary col-6 center-block text-center" role="alert">
                    {{ session('password') }}
                </div>
                <br>
            @endif
            <a class="btn btn-primary mb-3" href="{{ route('users.add') }}">Добавить</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Имя</th>
                        <th scope="col">Email</th>
                        <th scope="col">Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->_id) }}">Редактировать</a>
                                <a class="bg-warning" href="{{ route('users.destroy', $user->_id) }}">Del</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
