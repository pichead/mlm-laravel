<nav class="navbar fixed-top navbar-dark navbar-expand-sm" style="background-color:#666a77;">
    <div class="container px-0 mx-0 mx-lg-5 px-lg-5 col-12 pr-lg-5">
        <!-- <div class="col-12 col-md-8"> -->
            <img class="ml-4 ml-md-0 ml-lg-auto" src="{{ URL::to('others/favicon/vdealer-logo-sq300.png') }}" width="65" height="65">
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-0 ml-sm-auto">
                
                @guest
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li> --}}
                {{-- @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif --}}
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right col-1 col-md" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('ออกจากระบบ') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>



        </div>
        <!-- </div> -->
    </div>
</nav>
<br>
<br>
<br>
<br>