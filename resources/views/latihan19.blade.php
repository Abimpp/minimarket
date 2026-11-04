
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($produk as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ $item->kategori }}</td>
                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->stok }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Produk tidak ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
</table>
