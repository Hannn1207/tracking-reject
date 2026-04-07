<?php

namespace App\Filament\Resources\RejectReports\Pages;

use App\Filament\Resources\RejectReports\RejectReportResource;
use Dom\Text;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;


class EditRejectReport extends EditRecord
{
    protected static string $resource = RejectReportResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Simpan'),
            Action::make('back')
                ->label('Kembali')
                ->url(RejectReportResource::getUrl('index'))
                ->color('danger'),

            Action::make('done')
                ->label('Done')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Submit')
                ->modalDescription('Pastikan semua data yang dimasukkan sudah benar. Data yang telah disubmit tidak dapat diubah kembali.')
                ->modalSubmitActionLabel('Submit')
                ->visible(fn(): bool => $this->getRecord()->status === 'draft')
                ->schema([
                    TextInput::make('total_reject_fg')
                        ->label('Total Reject FG')
                        ->readOnly()
                        ->dehydrated(true)
                        // Untuk Menjumlahkan Reject dari FG
                        ->default(fn() => $this->getRecord()?->ng_totals['FG'] ?? 0),
                    TextInput::make('total_reject_stl_htr')
                        ->label('Total Reject STL/HTR')
                        ->readOnly()
                        ->dehydrated(true)
                        // Untuk Menjumlahkan Reject dari STL/HTR
                        ->default(fn() => $this->getRecord()?->ng_totals['STL/HTR'] ?? 0),
                    TextInput::make('total_reject_mc')
                        ->label('Total Reject MC')
                        ->readOnly()
                        ->dehydrated(true)
                        // Untuk Menjumlahkan Reject dari MC
                        ->default(fn() => $this->getRecord()?->ng_totals['MC'] ?? 0),
                    TextInput::make('total_reject_inpk')
                        ->label('Reject INPK')
                        ->numeric()
                        ->live(onBlur: true)
                        ->required()
                        // Untuk Menjumlahkan Reject dari INPK
                        ->default(1)
                        ->afterStateUpdated(function ($set, $get) {
                            $set(
                                'total_reject',
                                ($get('total_reject_fg') ?? 0) +
                                    ($get('total_reject_stl_htr') ?? 0) +
                                    ($get('total_reject_mc') ?? 0) +
                                    ($get('total_reject_inpk') ?? 0)
                            );
                        }),

                    TextInput::make('total_reject')
                        ->label('Total Reject')
                        ->readOnly()
                        ->dehydrated(true)
                        ->afterStateHydrated(function ($set, $get) {
                            $set(
                                'total_reject',
                                ($get('total_reject_fg') ?? 0) +
                                    ($get('total_reject_stl_htr') ?? 0) +
                                    ($get('total_reject_mc') ?? 0) +
                                    ($get('total_reject_inpk') ?? 0)
                            );
                        }),
                    TextInput::make('total_qty_proses')
                        ->label('Total Proses')
                        ->readOnly()
                        ->dehydrated(true)
                        ->default(function () {
                            $record = $this->getRecord();
                            if (!$record) {
                                return 0;
                            }
                            return (int) $record->processes()->sum('qty_proses');
                        }),
                    TextInput::make('total_repair')
                        ->label('Total Repair')
                        ->readOnly()
                        ->dehydrated(true)
                        ->default(fn() => $this->getRecord()->total_repair ?? 0),
                    TextInput::make('keterangan')
                        ->label('Keterangan')
                        ->nullable(),
                ])
                ->modalHeading('Isi Total Produksi')
                ->action(function (array $data): void {
                    $record = $this->getRecord();
                    $record->totalProduksi()->updateOrCreate(
                        ['reject_report_id' => $record->id,],
                        [
                            'total_reject_fg' => $data['total_reject_fg'],
                            'total_reject_stl_htr' => $data['total_reject_stl_htr'],
                            'total_reject_mc' => $data['total_reject_mc'],
                            'total_reject_inpk' => $data['total_reject_inpk'],
                            'total_reject' => $data['total_reject'],
                            'total_qty_proses' => $record->processes_sum_qty_proses ?? 0,
                            'total_repair' => $data['total_repair'],
                            'keterangan' => $data['keterangan'],
                        ]
                    );

                    $record->update(['status' => 'submitted']);

                    Notification::make()
                        ->success()
                        ->title('Total produksi disimpan dan status diperbarui ke submitted.')
                        ->send();

                    $this->redirect(RejectReportResource::getUrl('index'));
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn($record) => Auth::user()->role !== 'operator'),
        ];
    }
}
