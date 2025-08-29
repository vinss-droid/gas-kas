<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class IncomeTableWidget extends TableWidget
{
    protected static ?string $heading = 'Table Pemasukan (5 data terakhir)';
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder =>
                Income::query()->limit(5)->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Yang Bayar'),
                TextColumn::make('year')
                    ->searchable()
                    ->label('Tahun'),
                TextColumn::make('month')
                    ->searchable()
                    ->label('Bulan'),
                TextColumn::make('week')
                    ->searchable()
                    ->label('Minggu Ke'),
                TextColumn::make('paymentMethod.name')
                    ->label('Metode Pembayaran'),
                TextColumn::make('amount')
                    ->label('Jumlah Bayar'),
                TextColumn::make('paid_at')
                    ->date(format: 'Y-m-d')
                    ->label('Dibayar Pada'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
