# Folder Structure

This project follows the standard Laravel directory structure with the following additions:

## `app/Services`
Contains common reusable services. All services adhere to an interface-driven design.

- **`File`**: `FileUploadService` - Local and S3 file uploads.
- **`Image`**: `ImageResizeService` - Image manipulation using Intervention Image.
- **`Notification`**: `NotificationService` - Unified notification sender (Email, SMS, WhatsApp, Pusher).
- **`OTP`**: `OTPService` - OTP generation and verification.
- **`Activity`**: `ActivityLoggingService` - Logs user actions to the database.

## `app/Http/Middleware`
- **`CheckPortalPermission`**: Enforces portal-scoped permissions.

## `resources/views`
- **`admin/logs`**: Log Viewer views.
- **`errors`**: Custom error pages (403, 404, 419, 500).

## `docs`
Project documentation.
