<?php

namespace App\Filament\Resources\RejectReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;


class RejectReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')->date('d-m-Y')->sortable()->searchable(),
                TextColumn::make('meja')->searchable(),
                TextColumn::make('line')->searchable(),
                TextColumn::make('shift')->searchable(),

                TextColumn::make('part.part_name')
                    ->label('Type')
                    ->searchable(),

                TextColumn::make('lot_number')
                    ->label('Nomor Lot')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Input By')
                    ->searchable(),
                TextColumn::make('total_reject')->label('Total Reject')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('processes_sum_qty_proses')->label('Total Proses')
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->color(fn(string $state): string => match ($state) {
                        'draft'     => 'gray',
                        'submitted' => 'info',    // biru
                        'approved'  => 'success', // hijau
                        default     => 'secondary',
                    })
                    ->icon(fn(string $state): ?string => match ($state) {
                        'draft'     => 'heroicon-o-pencil',
                        'submitted' => 'heroicon-o-paper-airplane',
                        'approved'  => 'heroicon-o-check-circle',
                        default     => null
                    }),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
            ])



            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'approved' => 'Approved',
                    ]),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn($record) => Auth::user()->role !== 'operator'),
                ]),
            ]);
    }
}
