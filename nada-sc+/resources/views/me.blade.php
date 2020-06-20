<body>
    <h1>{{ $user->user_name }} info</h1>
    [student_code]
    {{ $user->student_code }}<br>
    [name]
    {{ $user->user_name }}<br>
    [email]
    {{ $user->email }}<br>
    <ul>
        @foreach ($accounts as $account)
            <li>
                {{ "[name] " . $account->user_name }}<br>
                {{ "[email] " . $account->email }}
            </li>
        @endforeach
    </ul>
</body>
