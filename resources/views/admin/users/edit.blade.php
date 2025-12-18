<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">{{ __('Edit User') }}</h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <!-- Status Badge -->
                            <div class="mb-3">
                                <span class="fw-semibold">Status: </span>
                                @if($user->deleted_at)
                                    <span class="badge bg-danger">Deleted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password (Optional) -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password (leave blank to keep current)') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>

                            <!-- Roles -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('Roles') }}</label>
                                <div class="border rounded p-3 bg-light">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> {{ __('Update User') }}
                                    </button>
                                </div>

                                @if($user->id !== auth()->id() && !$user->trashed())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> {{ __('Delete User') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
