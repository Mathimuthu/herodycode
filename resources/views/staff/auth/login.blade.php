<h2>Manager Login</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('staff.login') }}">
    {{ csrf_field() }}
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <label><input type="checkbox" name="remember"> Remember Me</label><br>
    <button type="submit">Login</button>
</form>

<br>

<!-- Register Button -->
<form method="GET" action="{{ route('staff.register') }}">
    <button type="submit">Register</button>
</form>
