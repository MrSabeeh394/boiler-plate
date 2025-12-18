<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - Session Expired</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-clock-history text-info" style="font-size: 4rem;"></i>
                            <h1 class="display-4 mt-3">419</h1>
                            <h2 class="h4 text-muted mb-3">Session Expired</h2>
                            <p class="text-muted mb-4">
                                Your session has expired. Please refresh the page and try again.
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-clockwise"></i> Refresh Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
