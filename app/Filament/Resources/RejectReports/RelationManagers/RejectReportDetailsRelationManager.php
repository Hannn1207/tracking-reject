<?php

namespace App\Filament\Resources\RejectReports\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Hidden;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class RejectReportDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';
    protected static ?string $title = 'Reject';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('reject_type_id')
                ->label('Reject Type')
                ->relationship('rejectType', 'nama_reject')
                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    "{$record->nama_reject} ({$record->asal_reject})"
                )
                ->searchable()
                ->preload(false)
                ->required()
                ->nullable(),

            Select::make('status_reject')
                ->label('Status Reject')
                ->options([
                    'NG'  => 'NG',
                    'OK'  => 'OK',
                    'REP' => 'REP',
                ])
                ->required(),

            TextInput::make('qty_reject')
                ->label('Jumlah Reject')
                ->numeric()
                ->required()
                ->minValue(0)
                ->nullable(),

            Hidden::make('user_id')
                ->default(fn() => Auth::id()),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rejectType.nama_reject')
                    ->label('Nama Reject')
                    ->searchable(),

                TextColumn::make('qty_reject')
                    ->label('Jumlah Reject')
                    ->sortable(),

                TextColumn::make('status_reject')
                    ->label('Status Reject')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'NG'  => 'danger',   // merah
                        'REP' => 'warning',  // kuning
                        'OK'  => 'success',  // hijau
                        default => 'gray',
                    }),

                TextColumn::make('user.name')
                    ->label('Input By')
                    ->toggleable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('New Detail')
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
