@component('mail::message')
    # Hello {{$user->name}}

    You have changed your email id. Please verify your new email using button link:

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
