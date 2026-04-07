<?php

namespace App\Filament\Resources\Users\Schemas;

use Dom\Text;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('npk')
                    ->required()
                    ->placeholder('Masukkan NPK Karyawan')
                    ->unique(ignoreRecord: true)
                    ->numeric(),
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->placeholder('Masukkan Nama Lengkap')
                    ->maxLength(50)
                    ->required(),
                Select::make('role')
                    ->label('Jabatan')
                    ->options([
                        'operator' => 'Operator',
                        'leader' => 'Leader',
                        'foreman' => 'Foreman',
                    ])
                    ->required(),
                TextInput::make('email')
                    ->placeholder('Contoh: npk@vis.com')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable(),
            ]);
    }
}
