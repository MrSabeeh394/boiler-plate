<?php

namespace App\Services\Log;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LogViewerService
{
    protected string $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
    }

    /**
     * Get all log files.
     */
    public function getLogFiles(): array
    {
        if (!File::exists($this->logPath)) {
            return [];
        }

        $files = File::files($this->logPath);
        $logFiles = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'log') {
                $logFiles[] = [
                    'name' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'modified' => $file->getMTime(),
                ];
            }
        }

        // Sort by modified time (newest first)
        usort($logFiles, fn($a, $b) => $b['modified'] <=> $a['modified']);

        return $logFiles;
    }

    /**
     * Get log content by filename.
     */
    public function getLogContent(string $filename): ?string
    {
        $filepath = $this->logPath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filepath)) {
            return null;
        }

        return File::get($filepath);
    }

    /**
     * Parse log entries from content.
     */
    public function parseLogEntries(string $content): array
    {
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*?)(?=\[\d{4}-\d{2}-\d{2}|$)/s';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $entries = [];
        foreach ($matches as $match) {
            $entries[] = [
                'timestamp' => $match[1] ?? '',
                'environment' => $match[2] ?? '',
                'level' => strtoupper($match[3] ?? ''),
                'message' => $this->maskSensitiveData(trim($match[4] ?? '')),
            ];
        }

        return array_reverse($entries); // Newest first
    }

    /**
     * Filter entries by log level.
     */
    public function filterByLevel(array $entries, ?string $level): array
    {
        if (!$level) {
            return $entries;
        }

        return array_filter($entries, fn($entry) => $entry['level'] === strtoupper($level));
    }

    /**
     * Mask sensitive data in log messages.
     */
    protected function maskSensitiveData(string $message): string
    {
        // Mask passwords
        $message = preg_replace('/(password["\']?\s*[:=]\s*["\']?)([^"\'}\s,]+)/i', '$1***MASKED***', $message);
        
        // Mask tokens
        $message = preg_replace('/(token["\']?\s*[:=]\s*["\']?)([^"\'}\s,]+)/i', '$1***MASKED***', $message);
        
        // Mask API keys
        $message = preg_replace('/(api[_-]?key["\']?\s*[:=]\s*["\']?)([^"\'}\s,]+)/i', '$1***MASKED***', $message);
        
        // Mask secrets
        $message = preg_replace('/(secret["\']?\s*[:=]\s*["\']?)([^"\'}\s,]+)/i', '$1***MASKED***', $message);

        return $message;
    }

    /**
     * Get available log levels.
     */
    public function getLogLevels(): array
    {
        return [
            'DEBUG',
            'INFO',
            'NOTICE',
            'WARNING',
            'ERROR',
            'CRITICAL',
            'ALERT',
            'EMERGENCY',
        ];
    }
}
