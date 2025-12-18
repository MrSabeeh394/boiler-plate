<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get available log files
        $logPath = storage_path('logs');
        $files = File::glob($logPath . '/*.log');
        $availableDates = [];
        
        foreach ($files as $file) {
            $filename = basename($file);
            if ($filename === 'laravel.log') {
                $availableDates[] = 'today';
            } elseif (preg_match('/laravel-(.*).log/', $filename, $matches)) {
                $availableDates[] = $matches[1];
            }
        }
        
        // 2. Determine file to read
        $date = $request->get('date', 'today');
        $filePath = $date === 'today' ? $logPath . '/laravel.log' : $logPath . '/laravel-' . $date . '.log';

        if (!File::exists($filePath)) {
            return view('admin.logs.index', ['logs' => [], 'dates' => $availableDates, 'currentDate' => $date]);
        }

        // 3. Read and Parse Logs
        $content = File::get($filePath);
        $pattern = '/^\[(?<date>.*)\] (?<env>\w+)\.(?<level>\w+): (?<message>.*)/m';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $logs = [];
        foreach ($matches as $match) {
            $logs[] = [
                'timestamp' => $match['date'],
                'env' => $match['env'],
                'level' => strtolower($match['level']),
                'message' => $this->maskSensitive($match['message']),
            ];
        }

        // Reverse to show newest first
        $logs = array_reverse($logs);
        $logsCollection = collect($logs);

        // 4. Filter
        if ($level = $request->get('level')) {
            $logsCollection = $logsCollection->where('level', $level);
        }

        // 5. Paginate
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $logsCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedLogs = new LengthAwarePaginator($currentItems, $logsCollection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('admin.logs.index', [
            'logs' => $paginatedLogs, 
            'dates' => $availableDates, 
            'currentDate' => $date,
            'levels' => ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency']
        ]);
    }

    private function maskSensitive($message)
    {
        // Simple masking for email and password patterns
        $message = preg_replace('/([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', '***@***.***', $message);
        // Mask specific keys if visible in JSON/Array dumps
        // This is basic; a robust solution would parse JSON.
        return $message;
    }
}
