<header class="stick-top forsticky new-header">
    <div class="menu-sec">
        <div class="container">
            <div class="logo">
                <a href="{{ url('/') }}" title="">
                    <img class="hidesticky" src="{{ asset('assets/main/images/Viti.png') }}" width="60px" alt="" />
                    <img class="showsticky" src="{{ asset('assets/main/images/Viti.png') }}" width="60px" alt="" />
                </a>
            </div>

            <div class="btn-extars">
                <!-- No Business Button for logged-in manager -->
            </div>

            <nav>
                <ul>
                    <li class="menu-item">
                        <a href="{{ route('manager.dashboard') }}">Manager Home</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('projects') }}" title="">Internships</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('gigs') }}" title="">Gigs</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('campaigns') }}" title="">Projects</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('manager.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('manager-logout').submit();">
                            Logout
                        </a>
                        <form id="manager-logout" method="POST" action="{{ route('manager.logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
