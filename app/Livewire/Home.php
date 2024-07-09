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

        
        // Mengambil semua data items dari transaksi
        $allItems = Transaksi::all()->pluck('items');
       

        // Mengolah data items untuk mendapatkan jumlah total
        $itemTotals = [];
        foreach ($allItems as $items) {
            $items = json_decode($items, true);
            foreach ($items as $item => $detail) {
                $product = $item;
                $qty = $detail['qty'];
                $price = $detail['price'];
                $unit = $detail['unit'];

                if (!isset($itemTotals[$product])) {
                    $itemTotals[$product] = [
                        'total_qty' => 0,
                        'total_price' => 0,
                        'unit' => $unit,
                    ];
                }

                $itemTotals[$product]['total_qty'] += $qty;
                $itemTotals[$product]['total_price'] += $price * $qty;
            }
        }
        
        
        $sortedItems = collect($itemTotals)->sortByDesc('total_price')->take(5);
        // dd($sortedItems);

        return view('livewire.home', [
            'monthly' => $transaksi->get()->sum('price'),
            'today' => $transaksi->whereDate('created_at', $today)->get()->sum('price'),
            'todayCount' => $transaksi->whereDate('created_at', $today)->count(),
            'datas' => Transaksi::where('status', '<>', 'sudah diambil')
                                ->orderBy('created_at', 'desc')
                                ->get(),
            'chart' => $data['chart'],
            'topItems' => $sortedItems,
        ]);
    }
}
