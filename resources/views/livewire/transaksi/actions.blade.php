<div class="page-wrapper">
    <div class="grid grid-cols-2 gap-6">
        <div class="card card-divider h-fit">
            <div class="card-body">
                <input type="search" class="input input-bordered" placeholder="Cari Service" wire:model.live="search">
            </div>
            <div>
            </div>
            @foreach ($services as $unit => $service)
                <div class="card-body">
                    <h3 class="text-xl font-bold capitalize">Per {{ $unit }} :</h3>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach ($service as $item)
                            <button class="avatar" wire:click="addItem({{ $item->id }})">
                                <div class="w-full rounded-lg">
                                    <img src="{{ $item->foto }}" alt="">
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card h-fit">
            <form class="card-body space-y-4" wire:submit="simpan">
                <h3 class="card-title">Detail Transaksi</h3>

                <div @class(['table-wrapper ', 'border-error' => $errors->first('items')]) required>
                    <table class="table">
                        <thead>
                            <th>Nama Menu</th>
                            <th></th>
                            <th>Qty</th>
                            <th></th>
                            <th>Harga</th>

                        </thead>
                        <tbody>
                            @foreach ($items as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>

                                    <td>
                                        <button class="btn btn-xc btn-square"
                                            wire:click="removeItem('{{ $key }}')">
                                            <x-tabler-minus class="size-4" />
                                        </button>
                                    </td>
                                    <td>{{ $value['qty'] }}</td>

                                    <td>
                                        <button class="btn btn-xc btn-square"
                                            wire:click="plusItem('{{ $key }}')">
                                            <x-tabler-plus class="size-4" />
                                        </button>
                                    </td>
                                    <td>{{ Number::format($value['price']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div x-data="{ open: false, search: '', selected: '' }">
                    <div class="relative">
                        <input x-model="search" @click="open = true" @click.away="open = false" type="text"
                            placeholder="Cari customer..." class="input input-bordered w-full mb-2" />
                        <div x-show="open && search.length >= 1"
                            class="absolute z-10 w-full bg-white mt-1 rounded-md shadow-lg">
                            <ul>
                                @foreach ($customers as $id => $name)
                                    <li x-show="'{{ $name }}'.toLowerCase().includes(search.toLowerCase())"
                                        @click="selected = '{{ $id }}'; search = '{{ $name }}'; open = false; $wire.set('form.customer_id', '{{ $id }}')"
                                        class="cursor-pointer p-2 hover:bg-gray-100">{{ $name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" wire:model="form.customer_id" x-bind:value="selected">
                </div>

                <select @class([
                    'select select-bordered',
                    'select-error' => $errors->first('vouchers'),
                ]) wire:model="selectedVoucher" wire:change="applyVoucher">
                    <option value="">Pilih Voucher</option>
                    @foreach ($voucherNames as $voucher)
                        <option value="{{ $voucher['id'] }}">
                            {{ $voucher['voucher_name'] }}</option>
                    @endforeach
                </select>


                <textarea rows="3" placeholder="Keterangan Transaksi" @class([
                    'textarea textarea-bordered',
                    'textarea-error' => $errors->first('items'),
                ]) wire:model="form.description"></textarea>
                <div class="card-actions justify-between">
                    <div class="flex flex-col">
                        <div class="text-xs">Total harga</div>
                        <div @class(['card-title', 'text-error' => $errors->first('items')])>Rp.
                            {{ Number::format($this->getPrice()) }}</div>
                    </div>
                    <button class="btn btn-primary">
                        <x-tabler-check class="size-5" />
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
