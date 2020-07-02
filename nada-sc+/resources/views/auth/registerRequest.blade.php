<body>
    <h1>RegisterRequest</h1>
    <form method="POST" action="{{ route('auth.register.request.post') }}">
        @csrf
        [student_code]
        <input type="text" name="student_code">
        @if ($errors->has('student_code'))
        {{ $errors->first('student_code') }}
        @endif
        <br>
        [access_password]
        <input type="text" name="password">
        @if ($errors->has('password'))
        {{ $errors->first('password') }}
        @endif
        <br>
        <input type="submit">
        <br>
        {{ $msg }}
    </form>
</body>
