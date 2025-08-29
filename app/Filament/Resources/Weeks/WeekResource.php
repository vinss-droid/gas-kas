<?php

namespace App\Filament\Resources\Weeks;

use App\Filament\Resources\Weeks\Pages\ManageWeeks;
use App\Models\Week;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WeekResource extends Resource
{
    protected static ?string $model = Week::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'start_date';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('month')
                    ->required()
                    ->label('Bulan')
                    ->format('F Y') // tetap full date untuk parsing
                    ->extraInputAttributes(['type' => 'month'])
                    ->closeOnDateSelection(),
                Select::make('week_number')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                    ])
                    ->searchable()
                    ->required()
                    ->label('Minggu Ke'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                TextColumn::make('month')
                    ->searchable(),
                TextColumn::make('week_number')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWeeks::route('/'),
        ];
    }
}
