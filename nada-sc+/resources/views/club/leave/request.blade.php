<body>
    <h1>{{$name}} Leave</h1>
    <form method="POST" action="{{ route('club.leave') }}">
        @csrf
        <input type="hidden" name="name" value="{{ $name }}" readonly="true">
        <br>
        <input type="submit" value="leave">
    </form>
</body>
