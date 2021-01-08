{!! $html->table() !!}

@section('js')
    {!! $html->scripts() !!}

    <script>
        function deleteData(url) {
            if (!confirm("Вы подтверждаете удаление?")) return;
            return fetch(url, {
                method: 'DELETE',
                credentials: 'include',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(response => response).then(data => {
                location.reload();
            });
        }
    </script>

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
