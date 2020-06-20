<body>
    <h1>create</h1>
    <form method="POST" action="{{ route('club.n.post.store', ['name' => $name]) }}">
        @csrf
        [title]
        <input type="text" name="title">
        @if ($errors->has('title'))
        {{$errors->first('title')}}
        @endif
        <br>
        [body]<br>
        <textarea rows="10" cols="60" name="body"></textarea>
        @if ($errors->has('body'))
        {{$errors->first('body')}}
        @endif
        <br>
        <input type="submit">
    </form>
</body>
