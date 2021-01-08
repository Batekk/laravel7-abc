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
        <br>

        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="btn-group">
                    <a href="{{ $url_create }}" type="button" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Добавить
                    </a>
                </div>
            </div>
            <div class="box-body">
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
