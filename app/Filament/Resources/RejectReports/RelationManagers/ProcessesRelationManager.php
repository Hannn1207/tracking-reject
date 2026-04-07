<?php

namespace App\Filament\Resources\RejectReports\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProcessesRelationManager extends RelationManager
{
    protected static string $relationship = 'processes';
    protected static ?string $title = 'Proses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('qty_proses')
                    ->numeric()
                    ->required(),
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('qty_proses')
            ->columns([
                TextColumn::make('qty_proses')
                    ->label('Qty Proses'),
                TextColumn::make('user.name')
                    ->label('Input By'),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('New Process')
                    ->visible(fn() => $this->getOwnerRecord()?->status === 'draft'),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => $this->getOwnerRecord()?->status === 'draft'),

                DeleteAction::make()
                    ->visible(fn() => $this->getOwnerRecord()?->status === 'draft'),
            ]);
    }
}
