@extends('layouts.app')

@section('content')
    <div class="card col-6">
        <div class="card-header">
            Пользователи
        </div>
        <div class="card-body">
            @if(!$user)
                {!! Form::open(array('url' => route('users.add'),'method'=>'POST')) !!}
            @else
                {!! Form::model($user, array('url' => route('users.update', $user->_id), 'method'=>'GET')) !!}
            @endif
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
            @include('components.buttonSaveBack')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
