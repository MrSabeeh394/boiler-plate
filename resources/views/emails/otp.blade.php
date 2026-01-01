# Your Verification Code

Use the code below to verify your account. This code is valid for {{ config('otp.expiry_minutes', 10) }} minutes.

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

If you did not request this code, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
