# Deployment Notes

## Environment Variables
Ensure the following variables are set in production:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `SUPER_PASSWORD` (Set strong value or remove entirely if not needed)

## Permissions
Ensure `storage/logs` and `storage/framework` are writable by the web server.

## Scheduler
Set up the cron job for Laravel Scheduler if using queued jobs or scheduled tasks:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Queue Worker
Run the queue worker for background processing (e.g. notifications):
```bash
php artisan queue:work
```
