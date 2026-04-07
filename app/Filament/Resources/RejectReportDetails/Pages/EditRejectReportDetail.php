<?php

namespace App\Filament\Resources\RejectReportDetails\Pages;

use App\Filament\Resources\RejectReportDetails\RejectReportDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRejectReportDetail extends EditRecord
{
    protected static string $resource = RejectReportDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
