<?php
namespace App\Livewire;

use App\Charts\DailyIncome;
use App\Models\Transaksi;
use Livewire\Component;

class Home extends Component
{
    public $no = 1;

    protected $listeners = ['reload' => '$refresh'];

    protected $chart;

    public function mount(DailyIncome $chart)
    {
        $this->chart = $chart;
    }

    public function render()
    {
        $data['chart'] = $this->chart->build();
        $today = date('Y-m-d');
        [$tahun, $bulan] = explode('-', date('Y-m'));

        $transaksi = Transaksi::whereMonth('created_at', $bulan)
                              ->whereYear('created_at', $tahun);

        return view('livewire.home', [
            'monthly' => $transaksi->get()->sum('price'),
            'today' => $transaksi->whereDate('created_at', $today)->get()->sum('price'),
            'todayCount' => $transaksi->whereDate('created_at', $today)->count(),
            'datas' => Transaksi::where('status', '<>', 'sudah diambil')
                                ->orderBy('created_at', 'desc')
                                ->get(),
            'chart' => $data['chart']
        ]);
    }
}
