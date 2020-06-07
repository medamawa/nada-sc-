<body>
    <h1>Register</h1>
    <form method="POST" action="{{ route('auth.register.pre') }}">
        @csrf
        [student_code]
        {{ $student_code }}
        <input type="hidden" value="{{ $student_code }}" name="student_code" readonly="true" style="border: none">
        <br>
        [name]
        {{ $name }}
        <input type="hidden" value="{{ $name }}" name="name" readonly="true" style="border: none">
        <br>
        [class]
        {{ $class }}回生
        <input type="hidden" value="{{ $class }}" name="class" readonly="true" style="border: none">
        <br>
        [email]
        <input type="text" name="email">
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
        [password_confirm]
        <input type="text" name="password_confirmation">
        <br>
        <input type="submit">
    </form>
</body>
