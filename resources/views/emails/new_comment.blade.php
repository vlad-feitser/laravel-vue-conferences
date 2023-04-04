<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Добрый день, на конференции {{ $conference }} (<a href="{{ $urlConference }}">{{ $urlConference }}</a>)
    пользователь <strong>{{ $firstname }} {{ $lastname }}</strong> оставил комментарий на ваш доклад
    {{ $lecture }} (<a href="{{ $urlLecture }}">{{ $urlLecture }}</a>).
</body>

</html>
