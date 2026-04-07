<?php

namespace App\Filament\Resources\NameParts\Pages;

use App\Filament\Resources\NameParts\NamePartResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNameParts extends ListRecords
{
    protected static string $resource = NamePartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
