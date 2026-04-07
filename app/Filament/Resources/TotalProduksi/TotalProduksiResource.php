<?php

namespace App\Filament\Resources\TotalProduksi;

use App\Filament\Resources\TotalProduksi\Pages\EditTotalProduksi;
use App\Filament\Resources\TotalProduksi\Pages\ListTotalProduksis;
use App\Models\TotalProduksi;
use BackedEnum;
use Dom\Text;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;


class TotalProduksiResource extends Resource
{
    protected static ?string $model = TotalProduksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected static ?string $modelLabel = 'Total Production';
    protected static ?string $pluralModelLabel = 'Total Production';
    protected static ?string $recordTitleAttribute = 'reject_report_id';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rejectReport.name_part.part_name')
                    ->label('Type')
                    ->searchable(),
                TextColumn::make('rejectReport.lot_number')
                    ->label('Nomor Lot')
                    ->searchable(),
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
            ->defaultSort('id', 'desc')
            ->filters([
                Filter::make('tanggal')
                    ->schema([
                        DatePicker::make('tanggal_dari')
                            ->label('Dari Tanggal'),
                        DatePicker::make('tanggal_sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['tanggal_dari'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['tanggal_dari'])
                            )
                            ->when(
                                $data['tanggal_sampai'],
                                fn($query) => $query->whereDate('created_at', '<=', $data['tanggal_sampai'])
                            );
                    }),
            ])
        ;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTotalProduksis::route('/'),
        ];
    }
}
