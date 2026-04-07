<?php

namespace App\Filament\Resources\Targets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Ramsey\Uuid\Type\Time;

class TargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TimePicker::make('jam_awal')
                    ->label('Jam Awal')
                    ->seconds(false)
                    ->format('H:i')
                    ->displayFormat('H:i')
                    ->required(),
                TimePicker::make('jam_akhir')
                    ->label('Jam Akhir')
                    ->seconds(false)
                    ->format('H:i')
                    ->displayFormat('H:i')
                    ->required(),
                Select::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'lokal' => 'Lokal',
                        'ekspor' => 'Ekspor',
                    ])

                    ->required(),
                TextInput::make('qty')
                    ->label('Planing')
                    ->numeric()
                    ->required(),
            ]);
    }
}
