Hello {{$user->name}},
Thank you for creating an account. Please verify your email using this link:
{{route('verify', $user->verification_token)}}