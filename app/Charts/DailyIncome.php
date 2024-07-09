<?php

namespace App\Charts;

use marineusde\LarapexCharts\Charts\AreaChart AS OriginalAreaChart;
use Carbon\Carbon;
use App\Models\Transaksi; // Assuming Transaksi model stores sales data

class DailyIncome
{
    public function build(): OriginalAreaChart
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;

        $dailySales = array_fill(0, $daysInMonth, 0);

        $sales = Transaksi::whereYear('created_at', $currentYear)
                          ->whereMonth('created_at', $currentMonth)
                          ->get(['created_at', 'price']);

        foreach ($sales as $sale) {
            $day = Carbon::parse($sale->created_at)->day - 1;
            $dailySales[$day] += $sale->price;
        }

        // Memeriksa dan mengganti nilai non-numerik dengan 0
        foreach ($dailySales as $key => $value) {
            if (!is_numeric($value) || is_nan($value)) {
                $dailySales[$key] = 0;
            }
        }

        $daysLabels = array_map(function ($day) {
            return $day + 1;
        }, range(0, $daysInMonth - 1));
        
      

        return (new OriginalAreaChart)

            ->setTitle('Grafik Penjualan  ' . Carbon::now()->format('F Y'))
        ->addData('Income', $dailySales)
        ->setHeight(400)
        ->setXAxis($daysLabels)
        ->setGrid( '#3F51B5')
        ->setFontFamily('Montserrat Alternates')
        ->setColors(['#0069ff', '#303F9F'])
        ->setMarkers(['#3b4c68'], 7, 10);
            
            
    }
}
