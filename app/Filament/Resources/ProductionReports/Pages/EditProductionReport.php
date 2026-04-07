<?php

namespace App\Filament\Resources\ProductionReports\Pages;

use App\Filament\Resources\ProductionReports\ProductionReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditProductionReport extends EditRecord
{
    protected static string $resource = ProductionReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getFormActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url($this->getRedirectUrl())
                ->color('danger'),

        ];
    }
}
