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

    <div class="card">
        <div class="card-body d-flex flex-column">
            <div class="flex-grow-1">
                {{ $chart->container() }}
            </div>
        </div>
    </div>

</div>

<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
