<?php

namespace App\Filament\Resources\NameParts\Pages;

use App\Filament\Resources\NameParts\NamePartResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNamePart extends EditRecord
{
    protected static string $resource = NamePartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
