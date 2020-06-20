<body>
    <h1>{{ $name }} home</h1>
    <a href="{{ route('club.n.admin', ['name' => $name]) }}">admin</a><br>
    <a href="{{ route('club.n.members', ['name' => $name]) }}">members</a><br>
    <a href="{{ route('club.n.index', ['name' => $name]) }}">index</a><br>
    <a href="{{ route('club.n.post.create', ['name' => $name]) }}">new post</a><br>
</body>
