@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Форма Users</h5>
            </div>
            {!! Form::model($user, [
            'url' => route('users.update', ['_id' => $user->_id]),
            'method' => $user->_id ? 'PUT' : 'POST']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>_id</label>
                            {!! Form::text('_id', null, ['class'=>'form-control input-lg', $user->_id ? 'disabled': '']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>name</label>
                            {!! Form::text('name', null, ['class'=>'form-control input-lg']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>email</label>
                            {!! Form::text('email', null, ['class'=>'form-control input-lg']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>Компании пользователя</label>
                            @foreach(\App\Models\mongo\Company::all()->sortBy('name') as $company)
                                <input type="hidden" name="company_ids">
                                <div class="form-check">
                                    {{ Form::checkbox('company_ids[]', $company->_id, null, [
                                            "class"=> "form-check-input",
                                            'type'=>"checkbox",
                                            "id"=> $company->_id,
                                        ]) }}
                                    <label class="form-check-label" for="{{ $company->_id }}">
                                        {{ $company->name }} <a href="{{ route('companies.edit', $company->_id) }}">*</a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.ui.buttons-return-save', ['route' => route('users.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
