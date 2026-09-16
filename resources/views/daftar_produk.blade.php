
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
</head>
<body>
    <h1>Daftar Produk</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Gambar</th>
                <th>SKU</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>
                        <img src="{{ asset($item['gambar']) }}"
                            width="100"
                            height="100"
                            alt="{{ $item['nama'] }}">
                    </td>
                    <td>{{ $item['sku'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['stok'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

