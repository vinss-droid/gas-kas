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
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
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

    private static $month = [
        'Januari' => 'Januari',
        'Februari' => 'Februari',
        'Maret' => 'Maret',
        'April' => 'April',
        'Mei' => 'Mei',
        'Juni' => 'Juni',
        'Juli' => 'Juli',
        'Agustus' => 'Agustus',
        'September' => 'September',
        'Oktober' => 'Oktober',
        'November' => 'November',
        'Desember' => 'Desember',
    ];

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('user_id')
               ->required()
               ->searchable()
               ->options(User::pluck('name', 'id'))
                ->columnSpanFull()
               ->label('Yang Bayar'),
            TextInput::make('year')
                ->required()
                ->default(now()->year),
            Select::make('month')
                ->required()
                ->label('Bulan')
                ->searchable()
                ->options(self::$month),
            Select::make('week')
                ->required()
                ->label('Minggu Ke')
                ->searchable()
                ->options([
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                ]),
            Select::make('payment_method_id')
                ->required()
                ->label('Metode Pembayaran')
                ->searchable()
                ->options(PaymentMethod::pluck('name', 'id')),
            TextInput::make('amount')
                ->required()
                ->label('Jumlah Bayar')
                ->default(5000)
                ->numeric(),
            DatePicker::make('paid_at')
                ->label('Dibayar pada')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->recordTitleAttribute('Orang')
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomes::route('/'),
        ];
    }
}
