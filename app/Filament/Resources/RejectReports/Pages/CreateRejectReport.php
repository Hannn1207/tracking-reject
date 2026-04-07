<?php

namespace App\Filament\Resources\RejectReports\Pages;

use App\Filament\Resources\RejectReports\RejectReportResource;
use App\Models\RejectReport;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Actions\Action;


class CreateRejectReport extends CreateRecord
{
    protected static string $resource = RejectReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('saveAndFill')
                ->label('Simpan & Isi Detail')
                ->color('primary')
                ->action('saveAndFill'),
        ];
    }

    public function saveAndFill()
    {
        // Validate form and build data
        $this->form->validate();

        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeCreate($data);

        // Check for duplicate lot number and redirect to existing report if found
        $existing = RejectReport::where('lot_number', $data['lot_number'])->first();
        if ($existing) {
            Notification::make()
                ->warning()
                ->title('Lot Number sudah ada')
                ->body('Laporan reject dengan Lot Number ini sudah ada. Anda diarahkan ke halaman laporan tersebut.')
                ->send();

            return redirect()->to(RejectReportResource::getUrl('edit', [
                'record' => $existing,
            ]));
        }

        // Create the model directly and run afterCreate hook
        $this->record = RejectReport::create($data);
        $this->afterCreate();

        // Redirect to edit page of the created report (use relation manager there)
        return redirect()->to(RejectReportResource::getUrl('edit', [
            'record' => $this->record,
        ]));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'draft'; // PASTI draft saat dibuat
        return $data;
    }

    protected function afterCreate(): void
    {
        $report = $this->record; // ✅ BENAR

        if ($report->details()->count() > 0 && $report->status === 'draft') {
            $report->update([
                'status' => 'submitted',
            ]);
        }
    }
    protected function getRedirectUrl(): string
    {
        return RejectReportResource::getUrl('edit', [
            'record' => $this->record,
        ]);
    }
}
