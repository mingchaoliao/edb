<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">EDB</a>
    <div class="collapse navbar-collapse justify-content-right" id="navbarCollapse">
        <form class="form-inline mr-auto">
            <input id="headerSearchBox" class="form-control mr-sm-2" type="text" placeholder="Search">
            <a id="headerSearchBtn" class="btn btn-outline-success my-2 my-sm-0" href="#">Search</a>
            <script>
                $( document ).ready(function() {
                    $('#headerSearchBtn').click(function(e) {
                        e.preventDefault();
                        var q = $('#headerSearchBox').val();
                        if(!q) return;
                        window.location.href = "{{route('search.result')}}?q=" + q;
                    });
                });
            </script>
            <a class="btn btn-outline-success my-2 my-sm-0" href="{{route('search.index')}}" style="margin-left: 8px;">Advanced Search</a>
        </form>

        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('/species')}}">All Species</a></li>
            @if(!Auth::guest() && Auth::user()->role_id != 4)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarActionsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarActionsLink">
                        <a class="dropdown-item" href="{{url('/species/create')}}">Add Species</a>
                        <a class="dropdown-item" href="{{url('/species/approval')}}">Approval Page</a>
                        @if(Auth::user()->role_id == 1)
                            <a class="dropdown-item" href="{{url('/user')}}">User Management</a>
                            <a class="dropdown-item" href="{{url('/import')}}">Data Import</a>
                            <a class="dropdown-item" href="{{url('/backup')}}">Backup</a>
                        @endif
                    </div>
                </li>
            @endif
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{url('/login')}}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/register')}}">Register</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUserLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarUserLink">
                        <a class="dropdown-item" href="{{route('user.edit')}}">Profile</a>
                        @if(Auth::user()->role_id == 3)
                            <a class="dropdown-item" href="{{url('/request')}}">Request Result</a>
                        @endif

                        @if(app('cas')->isAuthenticated())
                            <a class="dropdown-item" href="{{ route('cas.logout') }}"></a>
                        @else
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        @endif

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @endif
        </ul>

    </div>
</nav>