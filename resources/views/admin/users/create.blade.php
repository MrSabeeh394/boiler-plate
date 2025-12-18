<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">{{ __('Create User') }}</h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <!-- Roles -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('Roles') }}</label>
                                <div class="border rounded p-3 bg-light">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
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

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('Create User') }}
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
