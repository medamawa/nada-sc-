<body>
    <h1>RegisterRequest</h1>
    <form method="POST" action="/register-request">
        @csrf
        [student_code]
        <input type="text" name="code">
        @if ($errors->has('code'))
        {{$errors->first('code')}}
        @endif
        <br>
        [access_password]
        <input type="text" name="pass">
        @if ($errors->has('pass'))
        {{$errors->first('pass')}}
        @endif
        <br>
        <input type="submit">
        <br>
        {{$msg}}
    </form>
</body>