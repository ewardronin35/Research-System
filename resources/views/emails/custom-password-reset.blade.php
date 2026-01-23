@component('mail::message')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{-- Your Logo --}}
<img src="{{ asset('images/pilarLogo.png') }}" alt="{{ config('app.name') }} Logo" style="max-height: 75px;">
@endcomponent
@endslot

{{-- Email Body --}}
# Password Reset Request

Dear {{ $user->name }},

We received a request to reset the password associated with your account. If you made this request, please click the button below to set a new password.

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
Set a New Password
@endcomponent

For your security, this link is only valid for **{{ $expireMinutes }} minutes**.

If you did not request a password reset, please disregard this email. Your account remains secure.

Sincerely,  
The {{ config('app.name') }} Team

{{-- Subcopy (for secondary image or fine print) --}}
@slot('subcopy')
@component('mail::subcopy')
<div style="text-align: center;">
    <img src="{{ asset('images/Research.png') }}" alt="Research Department" style="max-height: 90px; margin-top: 20px;">
</div>
@endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
@endcomponent
@endslot

@endcomponent