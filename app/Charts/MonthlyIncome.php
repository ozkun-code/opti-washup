<?php

namespace App\Charts;

use marineusde\LarapexCharts\Charts\AreaChart AS OriginalAreaChart;

class MonthlyIncome
{
    public function build(): OriginalAreaChart
    {
        return (new OriginalAreaChart)
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', [40, 93, 35, 42, 18, 82])
            ->addData('Digital sales', [70, 29, 77, 28, 55, 45])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
