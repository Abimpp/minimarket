<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umum</title>
</head>
<body>
    <h1>Halaman Umum</h1>
    <p>
        Selamat datang, {{ auth()->user()->name }}
    </p>
    <p>
        Role: {{ auth()->user()->role }}
    </p>
    <form action="/logout" method="POST">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form>
</body>
</html>