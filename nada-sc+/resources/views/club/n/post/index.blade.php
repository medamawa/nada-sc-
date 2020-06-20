<body>
    <h1>{{ $name }} posts</h1>
    <ul>
        @foreach ($posts as $post)
            <li>{{ "[" . $post->title . "] " . $post->body }}</li>
        @endforeach
    </ul>
    <a href="{{ route('club.n.post.create', ['name' => $name]) }}">new post</a><br>
</body>