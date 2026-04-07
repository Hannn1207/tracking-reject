<?php

namespace App\Filament\Resources\RejectReports\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class RejectReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->required()
                    ->disabledOn('edit'),

                TextInput::make('meja')
                    ->required()
                    ->disabledOn('edit')
                    ->placeholder('Contoh : 1'),

                TextInput::make('line')
                    ->placeholder('Contoh : 1')
                    ->required()
                    ->disabledOn('edit'),

                Select::make('shift')
                    ->options([
                        1 => 'Shift 1',
                        2 => 'Shift 2',
                        3 => 'Shift 3',
                    ])
                    ->required()
                    ->disabledOn('edit'),

                Select::make('part_id')
                    ->label('Part')
                    ->relationship(
                        name: 'part',
                        titleAttribute: 'part_name',
                        modifyQueryUsing: fn($query) => $query->select('id', 'part_name')
                    )
                    ->searchable()
                    ->optionsLimit(20)
                    ->required()
                    ->disabledOn('edit'),

                TextInput::make('lot_number')
                    ->label('Lot Number')
                    ->placeholder('Contoh : 2512-001-01')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabledOn('edit'),

                Textarea::make('keterangan')
                    ->default(null)
                    ->columnSpanFull(),


            ]);
    }
}
