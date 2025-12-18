<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">
            <i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    <i class="bi bi-hand-thumbs-up"></i> Welcome back, {{ Auth::user()->name }}!
                                </h3>
                                <p class="mb-0 opacity-75">
                                    You're logged in to your dashboard. Explore the features below.
                                </p>
                            </div>
                            <div class="d-none d-md-block">
                                <i class="bi bi-emoji-smile" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-person-circle text-primary" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Your Profile</h6>
                                <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">MFA Status</h6>
                                <h4 class="mb-0">
                                    @if(Auth::user()->mfa_enabled)
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-warning">Disabled</span>
                                    @endif
                                </h4>
                                <small class="text-muted">
                                    @if(Auth::user()->mfa_enabled)
                                        via {{ ucfirst(Auth::user()->mfa_channel) }}
                                    @else
                                        Not configured
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="bi bi-calendar-check text-info" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Member Since</h6>
                                <h4 class="mb-0">{{ Auth::user()->created_at->format('M Y') }}</h4>
                                <small class="text-muted">{{ Auth::user()->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning-charge"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary w-100 py-3">
                                    <i class="bi bi-person-gear d-block mb-2" style="font-size: 2rem;"></i>
                                    Edit Profile
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('mfa.settings') }}" class="btn btn-outline-success w-100 py-3">
                                    <i class="bi bi-shield-lock d-block mb-2" style="font-size: 2rem;"></i>
                                    MFA Settings
                                </a>
                            </div>
                            @can('manage-users', 'admin')
                                <div class="col-md-3">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info w-100 py-3">
                                        <i class="bi bi-people d-block mb-2" style="font-size: 2rem;"></i>
                                        Manage Users
                                    </a>
                                </div>
                            @endcan
                            @can('view-logs', 'admin')
                                <div class="col-md-3">
                                    <a href="{{ route('admin.logs') }}" class="btn btn-outline-warning w-100 py-3">
                                        <i class="bi bi-file-text d-block mb-2" style="font-size: 2rem;"></i>
                                        View Logs
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
