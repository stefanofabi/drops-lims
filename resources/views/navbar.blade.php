        <nav class="navbar navbar-expand-lg navbar-dark bg-info">
            <a class="navbar-brand" href="@yield('home-href')"> <img width="30" height="30" src="{{ asset('images/logo.png') }}"> </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @section('navbar_menu')
            @show

	        <!-- Right Side Of Navbar -->
	        <ul class="navbar-nav ml-auto">
	            <li class="nav-item dropdown">
	                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	                  <img height="30px" width="30px" src="{{ asset('storage/avatars/'.Auth::user()->avatar ) }}" class="rounded-circle" alt="{{ Auth::user()->avatar }}"> {{ Auth::user()->name }} <span class="caret"> </span>
	                </a>

	                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	                    <a class="dropdown-item" href="#"> {{ trans('auth.signed_in_as', ['user' => Auth::user()->name ]) }} </a>

	                    <div role="none" class="dropdown-divider"> </div>

	                    <a class="dropdown-item" href="{{ route('logout') }}"
	                    onclick="event.preventDefault();
	                    document.getElementById('logout-form').submit();">
	                    {{ __('Logout') }}
	                    </a>

	                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                        @csrf
	                    </form>
	                </div>
	            </li>
	        </ul>
        </nav>