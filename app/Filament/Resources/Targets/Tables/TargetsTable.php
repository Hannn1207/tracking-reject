<?php

namespace App\Filament\Resources\Targets\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TargetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jam_awal')->label('Jam Awal')->sortable(),
                TextColumn::make('jam_akhir')->label('Jam Akhir'),
                TextColumn::make('jenis')->label('Jenis')->formatStateUsing(fn($state) => match ($state) {
                    'lokal' => 'Lokal',
                    'ekspor' => 'Export',
                }),
                TextColumn::make('qty')->label('Planing')->searchable(),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'lokal' => 'Lokal',
                        'ekspor' => 'Export',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
        ;
    }
}
