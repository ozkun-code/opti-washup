<div class="page-wrapper">
    <div class="grid grid-cols-3 gap-12">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-calendar style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title">Pendapatan Bulan ini</div>
                <div class="stat-value">Rp.{{ Number::format($monthly) }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-calendar-check style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title">Pendapatan Hari ini</div>
                <div class="stat-value">Rp.{{ Number::format($today) }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-list-check style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title">Pesanan Hari ini</div>
                <div class="stat-value">{{ $todayCount }} Pesanan</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-10 mt-12">
        <div class="card col-span-2 " style="max-width: 720px; max-height: 450px;">

            <div class="card-body" s>

                {!! $chart->container() !!}
            </div>
        </div>

        <div class="card col-span-1" style="max-width: 720px; max-height: 450px;">
            <!-- Perhatikan penambahan col-span-1 di sini -->
            <div class="card-body">
                <h3 class="text-xl font-semibold mb-4 text-center">Top 5 Service Terlaris</h3>
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($topItems as $product => $item)
                        <div class="bg-white rounded-lg overflow-hidden shadow-md p-4">
                            <div class="flex items-center space-x-2">
                                <div class="text-sm font-semibold">{{ $loop->iteration }}.</div>
                                <div class="flex-1 text-center text-sm font-semibold">{{ $product }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endpush
