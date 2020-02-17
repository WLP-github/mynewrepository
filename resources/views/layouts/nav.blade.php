<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="{{ url('/home') }}">FDA</a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('/') }}">Home</a>
        </li>
        <li class="nav-item mx-0 mx-lg-1">
            <div class="portfolio-item mx-auto">
                <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('guideline') }}">Guideline</a>
            </div>
        </li>
        @auth
        <li class="nav-item dropdown mx-0 mx-lg-1">
            <div class="portfolio-item mx-auto">
                <a href="{{ url('/profile') }}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger profile">Profile</a>
            </div>
        </li>
        <li class="nav-item mx-0 mx-lg-1">
            <div class="portfolio-item mx-auto" data-toggle="modal">
                <a href="{{ route('logout') }}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('LogOut') }}
                </a>
                <form id="logout-form" action="{{ route('user-logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        @else
            <li class="nav-item mx-0 mx-lg-1">
                <div class="portfolio-item mx-auto" data-toggle="modal">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('user-login')}}">Login</a>                    
                </div>
            </li>
            @if (Route::has('user.sign-up'))
                <li class="nav-item mx-0 mx-lg-1">
                    <div class="portfolio-item mx-auto" data-toggle="modal">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('user.sign-up') }}">Register</a>                    
                    </div>
                </li>
            @endif
        
        @endauth
       
      </ul>
    </div>
  </div>
</nav>