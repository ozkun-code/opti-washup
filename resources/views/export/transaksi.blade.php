<table>
    <thead>
        <tr>
            <th>code</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Keterangan</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($transaksis as $transaksi)
            <tr>
                dd
                <td>{{ $transaksi->id }}</td>
                <td>{{ $transaksi->created_at->format('d F Y H:i') }}</td>
                <td>{{ $transaksi->customer->name }}</td>
                <td>{{ Number::format($transaksi->price) }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
