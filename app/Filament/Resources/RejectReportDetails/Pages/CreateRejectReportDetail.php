<?php

namespace App\Filament\Resources\RejectReportDetails\Pages;

use App\Filament\Resources\RejectReportDetails\RejectReportDetailResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRejectReportDetail extends CreateRecord
{
    protected static string $resource = RejectReportDetailResource::class;

    public function mount(): void
    {
        parent::mount();

        if ($reportId = request()->query('reject_report_id')) {
            $this->form->fill([
                'reject_report_id' => $reportId,
            ]);
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
    protected function afterCreate(): void
    {
        $report = $this->ownerRecord;

        if ($report->status === 'draft') {
            $report->update([
                'status' => 'submitted',
            ]);
        }
    }
}
