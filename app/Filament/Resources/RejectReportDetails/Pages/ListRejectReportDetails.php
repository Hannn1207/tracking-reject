<?php

namespace App\Filament\Resources\RejectReportDetails\Pages;

use App\Filament\Resources\RejectReportDetails\RejectReportDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRejectReportDetails extends ListRecords
{
    protected static string $resource = RejectReportDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
