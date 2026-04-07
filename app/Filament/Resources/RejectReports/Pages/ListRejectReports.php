<?php

namespace App\Filament\Resources\RejectReports\Pages;

use App\Filament\Resources\RejectReports\RejectReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListRejectReports extends ListRecords
{
    protected static string $resource = RejectReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
