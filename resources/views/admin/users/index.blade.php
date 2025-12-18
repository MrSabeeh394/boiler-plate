<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">{{ __('Users') }}</h2>
    </x-slot>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> {{ __('Add User') }}
                    </a>
                    
                    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search..." style="width: 250px;">
                        <button type="submit" class="btn btn-secondary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </form>
                </div>

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

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($user->deleted_at)
                                            <span class="badge bg-danger">Deleted</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('impersonate', $user->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-person-check"></i> Impersonate
                                                    </button>
                                                </form>

                                                @if($user->trashed())
                                                    <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="bi bi-arrow-counterclockwise"></i> Restore
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
