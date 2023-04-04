<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Добрый день, на конференцию "{{ $conference }}" (<a href="{{ $urlConference }}">{{ $urlConference }}</a>)
    присоединился новый участник <strong>{{ $name }}</strong> с докладом на
    тему "{{ $lecture }}" (<a href="{{ $urlLecture }}">{{ $urlLecture }}</a>).<br><br>

    Время доклада: {{ date('H:i', strtotime($start_time)) }} - {{ date('H:i', strtotime($end_time)) }}
</body>

</html>
