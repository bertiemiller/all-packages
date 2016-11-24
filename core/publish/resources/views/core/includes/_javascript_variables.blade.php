@if(auth()->check())
    <script>
        window.Laravel.csrfToken = '{{ csrf_token() }}'
    </script>
@endauth