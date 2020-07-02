<body>
    <h1>{{$name}} Join</h1>
    <form method="POST" action="{{ route('club.join') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" readonly="true">
        <br>
        <input type="submit" value="join">
    </form>
</body>
