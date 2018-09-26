@component('mail::message')
# Change password Request

Click on the button below.

@component('mail::button', ['url' => 'http://localhost:4200/response-pass-reset?token='.$token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
