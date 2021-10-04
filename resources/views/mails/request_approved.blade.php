<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Request approved') }}</title>
</head>
<body>
    <ul>
        <li>{{ __('Date/Hour') }}: {{ $userRequest->start_date }}</li>
        <li>{{ __('Room') }}: {{ $userRequest->getRoom($userRequest->room_id)->name }}</li>
        <li>{{ __('Service Type') }}: {{ $userRequest->getServices($userRequest->id) }}</li>
        <li>{{ __('Number of persons') }}: {{ $userRequest->persons }}</li>
    </ul>
    <a href="{{ route('requests.show', $userRequest->id) }}">{{ __('Details') }}</a>
</body>
</html>