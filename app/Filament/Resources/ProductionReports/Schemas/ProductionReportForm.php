<?php

namespace App\Filament\Resources\ProductionReports\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class ProductionReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->disabledOn('edit'),
                TextInput::make('meja')
                    ->label('Meja')
                    ->placeholder('Contoh : Meja 1')
                    ->required()
                    ->disabledOn('edit'),
                TextInput::make('line')
                    ->label('Line')
                    ->placeholder('Contoh : Line 1')
                    ->required()
                    ->disabledOn('edit'),
            ]);
    }
}
