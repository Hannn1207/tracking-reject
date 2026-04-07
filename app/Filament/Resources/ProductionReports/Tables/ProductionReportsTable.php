<?php

namespace App\Filament\Resources\ProductionReports\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductionReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d F Y')
                    ->searchable(),
                TextColumn::make('meja')->label('Meja')->searchable(),
                TextColumn::make('line')->label('Line')->searchable(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->displayFormat('d-m-y')
                            ->label('Pilih Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['tanggal'],
                                fn(Builder $query, $date) => $query->whereDate('tanggal', $date)
                            );
                    }),
            ])

            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn($record) => Auth::user()->role === 'admin'),
                ]),
            ]);
    }
}
