<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class IncomeChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Pemasukan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $trendData = Trend::model(Income::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->sum('amount');

        $labels = [];
        $data = [];

        foreach ($trendData as $value) {
            $labels[] = $value->date;
            $data[] = $value->aggregate;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemasukan Tahunan',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
