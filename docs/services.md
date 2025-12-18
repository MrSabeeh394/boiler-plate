# Service Usage Examples

## File Upload Service
```php
use App\Services\File\FileUploadServiceInterface;

public function store(Request $request, FileUploadServiceInterface $uploader)
{
    if ($request->hasFile('document')) {
        $result = $uploader->upload($request->file('document'), 'uploads/documents');
        // $result = ['path' => '...', 'url' => '...', 'size' => 123, 'mime_type' => 'application/pdf']
    }
}
```

## Image Resize Service
```php
use App\Services\Image\ImageResizeServiceInterface;

public function store(Request $request, ImageResizeServiceInterface $resizer)
{
    $request->file('photo')->storeAs('images', 'original.jpg');
    $path = storage_path('app/images/original.jpg');
    
    // Resize to 800x600
    $resizer->resize($path, 800, 600);
    
    // Create Thumbnail
    $resizer->createThumbnail($path);
}
```

## Notification Service
```php
use App\Services\Notification\NotificationServiceInterface;

public function notify(NotificationServiceInterface $notifier)
{
    $notifier->send($user, "Your order is ready!", ['email', 'sms']);
}
```

## OTP Service
```php
use App\Services\OTP\OTPServiceInterface;

public function sendOtp(OTPServiceInterface $otpService)
{
    $otp = $otpService->generate('user@example.com');
    // Send $otp via notification...
}

public function verifyOtp(OTPServiceInterface $otpService)
{
    $isValid = $otpService->verify('user@example.com', '123456');
}
```

## Activity Logging Service
```php
use App\Services\Activity\ActivityLoggingServiceInterface;

public function update(Request $request, ActivityLoggingServiceInterface $logger)
{
    // ... update logic
    $logger->log('updated', $user, ['name' => 'Old Name'], ['name' => 'New Name']);
}
```
