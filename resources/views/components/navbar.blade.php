<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Robral E-site</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                <li class="nav-item mt-2 me-3">
                    <h6>Hello! {{auth()->user()->name}}</h6>
                </li>
                    <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                           @csrf
                        </form>

                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="{{ route('form') }}">Login</a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="{{route('register.form')}}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
