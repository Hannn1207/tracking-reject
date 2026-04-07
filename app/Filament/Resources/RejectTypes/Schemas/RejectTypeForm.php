<?php

namespace App\Filament\Resources\RejectTypes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class RejectTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_reject')
                    ->label("Nama Reject")
                    ->placeholder('Nama Reject')
                    ->required(),

                Select::make('asal_reject')
                    ->label('Asal Reject')
                    ->options([
                        'FG' => 'FORGING',
                        'STL/HTR' => 'STELLITE/HTR',
                        'MC' => 'MACHINING',
                    ])
                    //
                    ->placeholder('Pilih Asal Reject')
                    ->required(),
            ]);
    }
}
