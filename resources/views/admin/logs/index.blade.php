<x-app-layout>
    <x-slot name="header">
        <h2 class="h3 mb-0">{{ __('System Logs') }}</h2>
    </x-slot>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('admin.logs') }}" class="d-flex gap-2">
                            <select name="date" onchange="this.form.submit()" class="form-select">
                                @foreach($dates as $d)
                                    <option value="{{ $d }}" {{ $currentDate == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('admin.logs') }}" class="d-flex gap-2">
                            <input type="hidden" name="date" value="{{ $currentDate }}">
                            <select name="level" onchange="this.form.submit()" class="form-select">
                                <option value="">All Levels</option>
                                @foreach($levels as $l)
                                    <option value="{{ $l }}" {{ request('level') == $l ? 'selected' : '' }}>{{ strtoupper($l) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <span class="text-muted small">{{ $logs->total() }} entries</span>
                    </div>
                </div>

                <!-- Log Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 180px;">Timestamp</th>
                                <th style="width: 80px;">Env</th>
                                <th style="width: 100px;">Level</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td class="text-nowrap small">{{ $log['timestamp'] }}</td>
                                    <td class="small">{{ $log['env'] }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($log['level'] === 'error' || $log['level'] === 'critical' || $log['level'] === 'alert' || $log['level'] === 'emergency') bg-danger
                                            @elseif($log['level'] === 'warning') bg-warning text-dark
                                            @elseif($log['level'] === 'info' || $log['level'] === 'notice') bg-info
                                            @elseif($log['level'] === 'debug') bg-secondary
                                            @else bg-secondary @endif">
                                            {{ strtoupper($log['level']) }}
                                        </span>
                                    </td>
                                    <td class="small" style="font-family: monospace; word-break: break-word;">
                                        {{ \Illuminate\Support\Str::limit($log['message'], 150) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
