<body>
    <h1>Verify</h1>
    <form method="POST" action="{{ route('auth.register.verify') }}">
        @csrf
        <input type="hidden" name="code" value="{{ $code }}" readonly="true" >
        [email]
        <input type="text" name="email" value="{{ $email }}" readonly="true" style="border: none">
        @if ($errors->has('email'))
        {{$errors->first('email')}}
        @endif
        <br>
        [password]
        <input type="text" name="password">
        @if ($errors->has('password'))
        {{$errors->first('password')}}
        @endif
        <br>
        <input type="submit">
    </form>
</body>
