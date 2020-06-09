Hello {{$user->name}},
You have changed your email id. Please verify your new email using this link:
{{route('verify', $user->verification_token)}}