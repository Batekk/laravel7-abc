@extends('layouts.app')

@section('content')
    <div class="container">
        @include("layouts.form-errors")
        @if (session('success'))
            <div class="alert alert-primary center-block text-center" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-danger center-block text-center" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class=" breadcrumb-item active" aria-current="page">
                    {{ $breadcrumb }}
                </li>
            </ol>
        </nav>
        <br>
        <div class="card">
            <div class="card-header">
                <a href="{{ $url_create }}" type="button" class="btn btn-primary float-right">
                    <i class="fa fa-plus"></i> Добавить
                </a>
            </div>
            <div class="card-body">
                @include("layouts.dataTable.table")
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function loginUser(url) {
            return fetch(url, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(response => response).then(data => {
                location.reload();
            });
        }
    </script>
@endsection
