<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    Добрый день, на конференции "{{ $conference }}" (<a href="{{ $urlConference }}">{{ $urlConference }}</a>) участник
    <strong>{{ $name }}</strong> с докладом на тему "{{ $lecture }}" (<a
        href="{{ $urlLecture }}">{{ $urlLecture }}</a>)
    перенес доклад на другое время.<br><br>



    Новое время доклада: {{ date('H:i', strtotime($start_time)) }} - {{ date('H:i', strtotime($end_time)) }}
</body>

</html>
