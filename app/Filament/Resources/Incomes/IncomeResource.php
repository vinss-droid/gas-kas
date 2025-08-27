<?php

namespace App\Filament\Resources\Incomes;

use App\Filament\Resources\Incomes\Pages\CreateIncome;
use App\Filament\Resources\Incomes\Pages\EditIncome;
use App\Filament\Resources\Incomes\Pages\ListIncomes;
use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Week;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use UnitEnum;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyEuro;

    protected static ?string $recordTitleAttribute = 'user_id';

    protected static ?string $label = 'Income';
    protected static ?string $pluralLabel = 'Income';
    protected static string | UnitEnum | null $navigationGroup = 'Cash Flows';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
           Select::make('user_id')
               ->required()
               ->searchable()
               ->options(User::pluck('name', 'id'))
               ->label('Yang Bayar'),
            Select::make('week_id')
                ->required()
                ->label('Minggu Ke')
                ->searchable()
                ->options(
                    Week::all()->mapWithKeys(function ($week) {
                        return [
                            $week->id => Carbon::parse($week->start_date)->format('d M Y') .
                                ' - ' .
                                Carbon::parse($week->end_date)->format('d M Y'),
                        ];
                    })
                ),
            Select::make('payment_method_id')
                ->required()
                ->label('Metode Pembayaran')
                ->searchable()
                ->options(PaymentMethod::pluck('name', 'id')),
            TextInput::make('amount')
                ->required()
                ->label('Jumlah Bayar')
                ->numeric(),
            DatePicker::make('paid_at')
                ->label('Dibayar pada')
                ->required()
                ->format('d M Y')
                ->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->recordTitleAttribute('Orang')
            ->columns([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WeekRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomes::route('/'),
            'create' => CreateIncome::route('/create'),
            'edit' => EditIncome::route('/{record}/edit'),
        ];
    }
}
