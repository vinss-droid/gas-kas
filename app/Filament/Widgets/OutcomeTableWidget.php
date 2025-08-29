<?php

namespace App\Filament\Widgets;

use App\Models\Outcome;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OutcomeTableWidget extends TableWidget
{
    protected static ?string $heading = 'Table Pengeluaran (5 data terakhir)';
    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder =>
                Outcome::query()->limit(5)->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('amount')
                    ->label('Jumlah Uang Keluar')
                    ->searchable(),
                TextColumn::make('spent_at')
                    ->label('Tanggal Uang Keluar')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Keperluan')
                    ->searchable(),
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
