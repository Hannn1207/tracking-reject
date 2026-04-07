<?php

namespace App\Filament\Resources\RejectTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;


class RejectTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_reject')
                    ->label('Nama Reject')
                    ->searchable(),

                TextColumn::make('asal_reject')
                    ->label('Asal Reject')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'FG' => 'FORGING',
                        'STL/HTR' => 'STELLITE / HTR',
                        'MC' => 'MACHINING',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'FG' => 'success',
                        'STL/HTR' => 'info',
                        'MC' => 'warning',
                        default => 'gray',
                    })
                //
            ])
            ->filters([
                SelectFilter::make('asal_reject')
                    ->label('Asal Reject')
                    ->options([
                        'FG' => 'Forging',
                        'STL/HTR' => 'Stellite / HTR',
                        'MC' => 'Machining',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
        ;
    }
}
