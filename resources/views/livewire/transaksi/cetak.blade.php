<div class="page-wrapper">
    <div class="max-w-m mx-auto space-y-5">
        <div class="text-center">
            <h3 class="font-bold text-xxl">{{ config('app.name') }}</h3>
            <p>Rengasdengklok, Karawang 41352</p>
        </div>
        <div class="py-4 space-y-4">
            <table class="w-full">
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td> {{ $transaksi->created_at ? $transaksi->created_at->format('d M H:i') : 'Tanggal tidak tersedia' }}
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $transaksi->customer->name ?? 'Nama tidak tersedia' }}</td>
                </tr>
                <tr>
                    <td>Resi</td>
                    <td>:</td>
                    <td>{{ $transaksi->id }}</td>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Service</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPembelian = 0;
                        foreach (json_decode($transaksi?->items, true) ?? [] as $item) {
                            $totalPembelian += $item['price'];
                        }
                        $discountNominal = ($totalPembelian * ($transaksi?->discount ?? 0)) / 100;
                        $totalBayar = $totalPembelian - $discountNominal;
                    @endphp

                    @foreach (json_decode($transaksi?->items, true) ?? [] as $key => $item)
                        <tr class="table-row-bordered">
                            <td>{{ $key }}</td>
                            <td>{{ $item['qty'] }} @if (isset($item['unit']))
                                    {{ $item['unit'] }}
                                @endif
                            </td>
                            <td>{{ Number::format($item['price']) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-row-bordered-thick">
                        <td>Total Pembelian</td>
                        <td>-</td>
                        <td>{{ Number::format($totalPembelian) }}</td>
                    </tr>
                    <tr class="table-row-bordered">
                        <td>Discount</td>
                        <td>{{ Number::format($transaksi?->discount ?? 0) }}%</td>
                        <td>-{{ Number::format($discountNominal) }}</td>
                    </tr>
                    <tr class="table-row-bordered">
                        <td>Total Bayar</td>
                        <td>-</td>
                        <td>{{ Number::format($totalBayar) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
