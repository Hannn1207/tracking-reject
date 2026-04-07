<?php

namespace App\Filament\Resources\RejectReportDetails\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class RejectReportDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('reject_report_id')
                    ->default(fn() => request()->query('reject_report_id') ?? null)
                    ->required()
                    ->numeric(),
                Select::make('reject_type_id')
                    ->nullable()
                    ->relationship('rejectType', 'nama_reject'),
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
                TextInput::make('qty_reject')
                    ->nullable()
                    ->numeric(),
            ]);
    }
}
