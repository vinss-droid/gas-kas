<?php

namespace App\Filament\Resources\Outcomes;

use App\Filament\Resources\Outcomes\Pages\ManageOutcomes;
use App\Models\Outcome;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class OutcomeResource extends Resource
{
    protected static ?string $model = Outcome::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;
    protected static string | UnitEnum | null $navigationGroup = 'Cash Flows';

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label('Jumlah Uang Keluar')
                    ->numeric()
                    ->required(),
                DatePicker::make('spent_at')
                    ->label('Tanggal Uang Keluar')
                    ->required(),
                Textarea::make('description')
                    ->label('Keperluan')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
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
            'index' => ManageOutcomes::route('/'),
        ];
    }
}
