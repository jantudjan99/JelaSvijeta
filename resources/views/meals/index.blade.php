<!DOCTYPE html>
<html>
<head>
    <title>Popis obroka</title>
</head>
<body>
    <h1>Popis obroka</h1>
    <ul>
        @foreach ($meals as $meal)
            <li>{{ $meal->name }}</li>
        @endforeach
    </ul>
</body>
</html>