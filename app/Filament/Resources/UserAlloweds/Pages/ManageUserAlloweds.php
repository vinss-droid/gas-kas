<?php

namespace App\Filament\Resources\UserAlloweds\Pages;

use App\Filament\Resources\UserAlloweds\UserAllowedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageUserAlloweds extends ManageRecords
{
    protected static string $resource = UserAllowedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
