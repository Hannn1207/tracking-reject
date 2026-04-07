<?php

namespace App\Filament\Resources\RejectReports\RelationManagers;

use Dom\Text;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Filament\Forms;

class TotalProduksiRelationManager extends RelationManager
{
    protected static string $relationship = 'totalProduksi';


    public function form(Schema $schema): Schema
    {
        return $schema
            #Form Total Produksi
            ->schema([
                Hidden::make('reject_report_id')
                    ->default(fn() => $this->ownerRecord->id),

                TextInput::make('total_reject_fg')
                    ->label('Total Reject FG')
                    ->numeric()
                    ->required(),

                TextInput::make('total_reject_stl_htr')
                    ->label('Total Reject STL/HTR')
                    ->numeric()
                    ->required(),

                TextInput::make('total_reject_mc')
                    ->label('Total Reject MC')
                    ->numeric()
                    ->required(),

                TextInput::make('total_qty_proses')
                    ->label('Total Proses')
                    ->numeric()
                    ->readOnly()
                    ->default(
                        fn() =>
                        (int) $this->getOwnerRecord()
                            ->processes()
                            ->sum('qty_proses')
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            #Table Total Produksi   
            ->columns([
                TextColumn::make('total_reject_fg')->label('Reject FG'),
                TextColumn::make('total_reject_stl_htr')->label('Reject STL/HTR'),
                TextColumn::make('total_reject_mc')->label('Reject MC'),
                TextColumn::make('total_reject_inpk')
                    ->label('INPK'),
                TextColumn::make('total_reject')
                    ->label('Total Reject'),
                TextColumn::make('total_qty_proses')->label('Total Proses')
                    ->label('Qty Proses')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d-m-Y'),
                TextColumn::make('total_repair')
                    ->label('Total Rep'),

            ])
            ->recordActions([]);
    }
}
