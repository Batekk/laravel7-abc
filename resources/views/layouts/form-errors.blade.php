@if ($errors->all())
    <div class="alert alert-danger">
        <strong>Внимание</strong> Обнаружены следующие ошибки, проверьте правильность заполнения!<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('alert'))
    <div class="justify-content-md-center col-md-auto alert alert-warning text-center">
        {{ session('alert') }}
    </div>
@endif