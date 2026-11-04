
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan Aktif</title>
</head>
<body>
    <h2>Daftar Pesanan Aktif</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal Pesan</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->tanggal_pesan }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->catatan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada pesanan yang sesuai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
