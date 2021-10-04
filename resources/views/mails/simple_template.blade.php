<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <p style="text-align: center;">{{ $body }}</p>
    @component('mail::button', ['url' => route('requests.show', $userRequest->id)])
        {{ __('Details') }}
    @endcomponent
</body>
</html>