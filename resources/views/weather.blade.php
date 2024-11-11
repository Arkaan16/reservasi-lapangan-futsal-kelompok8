<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Information</title>
</head>
<body>
    <h1>Weather in {{ $weather['name'] }}</h1>
    <p>Temperature: {{ $weather['main']['temp'] }} °C</p>
    <p>Weather: {{ $weather['weather'][0]['description'] }}</p>
    <p>Humidity: {{ $weather['main']['humidity'] }}%</p>
    <p>Wind Speed: {{ $weather['wind']['speed'] }} m/s</p>
</body>
</html>
