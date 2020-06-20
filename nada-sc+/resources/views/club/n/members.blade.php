<body>
    <h1>{{ $name }} members</h1>
    <ul>
        @foreach ($members as $member)
            <li>{{ $member }}</li>
        @endforeach
    </ul>
</body>
