<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>

<body>

    <h1>Login</h1>

    {{-- Menampilkan error validasi jika ada --}}
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/submit" method="POST">
        @csrf

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', old('name')) }}"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br><br>

        <label for="password_confirmation">Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation"><br><br>

        <button type="submit">Kirim</button>
    </form>
</body>

</html>