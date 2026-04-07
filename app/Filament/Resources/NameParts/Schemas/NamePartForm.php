<?php

namespace App\Filament\Resources\NameParts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class NamePartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('part_name')
                    ->placeholder('Contoh: Type-IN/EX')
                    ->required(),
                TextInput::make('customer')
                    ->required(),
                FileUpload::make('part_image')
                    ->disk('public')
                    ->directory('parts'),
            ]);
    }
}
