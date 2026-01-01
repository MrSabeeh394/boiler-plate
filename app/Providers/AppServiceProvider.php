<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\File\FileUploadServiceInterface::class, \App\Services\File\FileUploadService::class);
        $this->app->bind(\App\Services\Image\ImageResizeServiceInterface::class, \App\Services\Image\ImageResizeService::class);
        $this->app->bind(\App\Services\Notification\NotificationServiceInterface::class, \App\Services\Notification\NotificationService::class);
        $this->app->bind(\App\Services\OTP\OTPServiceInterface::class, \App\Services\OTP\OTPService::class);
        $this->app->bind(\App\Services\SMS\SMSServiceInterface::class, \App\Services\SMS\TwilioService::class);
        $this->app->bind(\App\Services\Activity\ActivityLoggingServiceInterface::class, \App\Services\Activity\ActivityLoggingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
