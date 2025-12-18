<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error</title>
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
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                            <h1 class="display-4 mt-3">500</h1>
                            <h2 class="h4 text-muted mb-3">Server Error</h2>
                            <p class="text-muted mb-4">
                                Something went wrong on our end. Please try again later.
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="bi bi-house"></i> Go to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
