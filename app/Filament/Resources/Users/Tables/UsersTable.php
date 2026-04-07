<?php

namespace App\Filament\Resources\Users\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('npk')->label('NPK')->sortable(),
                TextColumn::make('name')->searchable()->label('Nama Operator'),
                TextColumn::make('role')->searchable()->label('Jabatan'),
                TextColumn::make('email')->searchable(),


            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Jabatan')
                    ->options([
                        'operator' => 'Operator',
                        'leader' => 'Leader',
                        'foreman' => 'Foreman',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
