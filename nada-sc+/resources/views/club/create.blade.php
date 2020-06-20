<body>
    <h1>Create A New Club</h1>
    <form method="POST" action="{{ route('club.store') }}">
        @csrf
        [club_name]
        <input type="text" name="name">
        @if ($errors->has('name'))
        {{ $errors->first('name') }}
        @endif
        <br>
        <input type="submit">
        <br>
        {{ $msg }}
    </form>
</body>
