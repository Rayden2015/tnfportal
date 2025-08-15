<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Message' }}</title>
</head>
<body>
    {!! nl2br($body) !!}
</body>
</html>
