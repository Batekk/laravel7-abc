@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Форма Company</h5>
            </div>
            {!! Form::model($company, [
            'url' => route('companies.update', ['_id' => $company->_id]),
            'method' => $company->_id ? 'PUT' : 'POST']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>_id</label>
                            {!! Form::text('_id', null, ['class'=>'form-control input-lg', $company->_id ? 'disabled' : '']) !!}
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
                            <label>user_ids</label>
                            <p class='card-text'>
                                @foreach($company->users as $user)
                                    <a href="{{ route('users.edit', $user->_id) }}">{{ $user->name}}</a>@if($loop->count > 1 && !$loop->last),@endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.ui.buttons-return-save', ['route' => route('companies.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
