<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use App\Models\Outcome;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class CashFlowStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // --- Data Pemasukan (Income) ---
        $incomeData = Income::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('sum(amount) as total')
            ])
            ->pluck('total', 'date');

        // Buat rentang tanggal sekali saja untuk efisiensi
        $dates = collect(range(0, 29))->map(fn ($day) => now()->subDays($day)->format('Y-m-d'))->reverse();

        $chartDataIncome = $dates->map(fn ($date) => $incomeData->get($date, 0))->values()->toArray();

        // --- Data Pengeluaran (Outcome) ---
        $outcomeData = Outcome::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('sum(amount) as total')
            ])
            ->pluck('total', 'date');

        $chartDataOutcome = $dates->map(fn ($date) => $outcomeData->get($date, 0))->values()->toArray();

        // --- PERHITUNGAN UNTUK STAT SALDO (BALANCE) ---
        $totalIncome = Income::sum('amount');
        $totalOutcome = Outcome::sum('amount');
        $currentBalance = $totalIncome - $totalOutcome;

        // Buat data chart saldo dengan mengurangi income harian dengan outcome harian
        $chartDataBalance = collect($chartDataIncome)->map(function ($incomeValue, $key) use ($chartDataOutcome) {
            return $incomeValue - $chartDataOutcome[$key];
        })->toArray();


        return [
            Stat::make('Income', Number::currency(Income::sum('amount'), 'IDR', precision: 0))
                ->label('Pemasukan')
                ->description('Total Pemasukan Sejauh Ini')
                ->descriptionIcon(Heroicon::OutlinedBanknotes, IconPosition::Before)
                ->chart($chartDataIncome)
                ->color('success'),

            Stat::make('Outcome', Number::currency(Outcome::sum('amount'), 'IDR', precision: 0))
                ->label('Pengeluaran')
                ->description('Total Pengeluaran Sejauh Ini')
                ->descriptionIcon(Heroicon::OutlinedReceiptRefund, IconPosition::Before)
                ->chart($chartDataOutcome)
                ->color('danger'),

            // --- STAT BARU UNTUK SALDO SAAT INI ---
            Stat::make('Balance', Number::currency($currentBalance, 'IDR', precision: 0))
                ->label('Saldo Saat Ini')
                ->description('Sisa uang setelah dikurangi pengeluaran')
                ->descriptionIcon(Heroicon::OutlinedWallet, IconPosition::Before) // Ikon dompet WALLET
                ->chart($chartDataBalance)
                ->color($currentBalance >= 0 ? 'primary' : 'danger'), // Warna biru jika positif, merah jika negatif
        ];
    }
}
