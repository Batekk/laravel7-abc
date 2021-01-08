@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Юзеры</a>
                        <a href="{{ route('companies.index') }}" class="btn btn-primary">Компания</a>
                        <a href="{{ route('category.index') }}" class="btn btn-primary">Категория</a>
                        <a href="{{ route('services.index') }}" class="btn btn-primary">Сервисы</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
