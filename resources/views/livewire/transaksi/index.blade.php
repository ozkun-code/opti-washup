<div class="page-wrapper">
    <div class="flex justify-between">
        <input type="date" class="input input-bordered" wire:model.live="date">
        <a href="{{ route('transaksi.export') }}" class="btn btn-primary" wire:navigate>
            <x-tabler-upload class="size-5" />
            <span>Export Transaksi</span>
        </a>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>Resi</th>
                <th>Tanggal</th>

                <th>Customer</th>
                <th>Price</th>
                <th class="text-center">Status</th>
                <th>Actions</th>
            </thead>
            @php

            @endphp
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>

                        <td>{{ $transaksi->id }}</td>
                        <td>{{ $transaksi->created_at->format('d M H:i') }}</td>


                        <td>{{ $transaksi->customer->name }}</td>
                        <td>{{ Number::format($transaksi->price) }}</td>
                        <td class="text-center">{{ $transaksi->status }}</td>

                        <td>
                            <div class="flex justify-center gap-1">
                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('detailTransaksi', {transaksi : '{{ $transaksi->id }}'})">
                                    <x-tabler-folder class="size-4" />
                                </button>
                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('editTransaksi', {transaksi : '{{ $transaksi->id }}' })">
                                    <x-tabler-edit class="size-4" />
                                </button>

                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('deletTransaksi', {transaksi : '{{ $transaksi->id }}'})">
                                    <x-tabler-trash class="size-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('transaksi.update')
    @livewire('transaksi.detail')

</div>
