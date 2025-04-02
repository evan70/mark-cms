<form method="POST" action="{{ $action }}">
    {!! csrf_fields() !!}
    {{ $slot }}
</form>