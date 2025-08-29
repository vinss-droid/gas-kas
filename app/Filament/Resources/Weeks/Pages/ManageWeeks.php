<?php

namespace App\Filament\Resources\Weeks\Pages;

use App\Filament\Resources\Weeks\WeekResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWeeks extends ManageRecords
{
    protected static string $resource = WeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
