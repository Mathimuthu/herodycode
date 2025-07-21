<h2>Welcome Manager: {{ Auth::guard('staff')->user()->name }}</h2>
<a href="{{ route('staff.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>
<form id="logout-form" method="POST" action="{{ route('staff.logout') }}" style="display: none;">
    {{ csrf_field() }}
</form>
