<h2>Manager Register</h2>
<form method="POST" action="{{ route('staff.register') }}">
    {{ csrf_field() }}
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required><br>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
    <button type="submit">Register</button>
</form>
