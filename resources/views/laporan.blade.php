<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
</head>
<body>

    <h1>Rekap Statistik Penjualan</h1>

    <p>Total Transaksi: {{ $laporan['total_transaksi'] }}</p>

    <p>Total Produk Terjual: {{ $laporan['total_produk'] }}</p>

    <p>
        Total Pendapatan:
        Rp {{ number_format($laporan['total_pendapatan'], 0, ',', '.') }}
    </p>

    <p>
        Produk Terlaris:
        {{ $laporan['produk_terlaris'] }}
    </p>

</body>
</html>
