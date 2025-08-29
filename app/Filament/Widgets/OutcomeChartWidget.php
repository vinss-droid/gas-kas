<?php

namespace App\Filament\Widgets;

use App\Models\Outcome;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class OutcomeChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Pengeluaran';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $trendData = Trend::model(Outcome::class)
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
                    'label' => 'Jumlah Pengeluaran Tahunan',
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
