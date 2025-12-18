<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top" style="height: 36px; width: auto;" />
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>

                @if(auth()->user()->hasPermissionToInPortal('manage-users', 'admin') || auth()->user()->hasPermissionToInPortal('view-logs', 'admin'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Admin') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            @if(auth()->user()->hasPermissionToInPortal('manage-users', 'admin'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-people"></i> {{ __('Manage Users') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermissionToInPortal('view-logs', 'admin'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.logs') }}">
                                        <i class="bi bi-file-text"></i> {{ __('View Logs') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('mfa.settings') }}">
                                <i class="bi bi-shield-lock"></i> {{ __('MFA Settings') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
