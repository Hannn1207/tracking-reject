<?php

namespace App\Filament\Resources\ProductionReports\RelationManagers;

use App\Models\Target;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Hidden;

class EksporDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Export';

    public function form(Schema $schema): Schema
    {
        $calculateOk = function (callable $set, callable $get) {
            $qtyScan = (int) $get('qty_scan');
            $ng      = (int) $get('ng');
            $repair  = (int) $get('repair');

            $set('ok', max($qtyScan - $ng - $repair, 0));
        };

        return $schema
            ->components([
                Select::make('target_id')
                    ->label('Jam Target')
                    ->relationship(
                        name: 'target',
                        titleAttribute: 'jam_awal',
                        modifyQueryUsing: fn($query) => $query->where('jenis', 'ekspor')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        $record->jam_awal . ' - ' . $record->jam_akhir
                    )
                    ->searchable()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('qty_target', Target::find($state)?->qty);
                    })
                    ->required(),
                TextInput::make('qty_target')
                    ->label('Planning')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(false)
                    ->formatStateUsing(fn($record) => $record?->target?->qty),

                TextInput::make('kode')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) use ($calculateOk) {
                        if (!$state) return;
                        $parts = array_map('trim', explode('|', $state));
                        $noLot = null;
                        $qty   = null;
                        foreach ($parts as $part) {
                            // 🔎 1️⃣ Cari nomor lot (universal semua brand)
                            if (!$noLot && preg_match('/-\d{4}-/', $part)) {
                                $noLot = $part;
                            }
                            // 🔎 2️⃣ Cari qty dengan "Pcs"
                            if (!$qty && stripos($part, 'pcs') !== false) {
                                $qty = (int) preg_replace('/[^0-9]/', '', $part);
                            }
                        }
                        // 🔎 3️⃣ Jika tidak ada Pcs (contoh Honda)
                        if (!$qty) {
                            foreach ($parts as $part) {
                                // hanya angka murni
                                if (preg_match('/^\d+$/', $part)) {
                                    $qty = (int) $part;
                                }
                            }
                        }
                        // 🚨 Validasi akhir
                        if (!$noLot || !$qty) {
                            Notification::make()
                                ->title('Format Barcode Tidak Dikenali')
                                ->danger()
                                ->send();

                            $set('no_lot', null);
                            $set('qty_scan', null);
                            return;
                        }
                        $set('no_lot', $noLot);
                        $set('qty_scan', $qty);

                        // ✅ TAMBAH KUMULATIF
                        $currentTotal = (int) $get('total_scan');
                        $newTotal = $currentTotal + $qty;

                        $set('total_scan', $newTotal);

                        $calculateOk($set, $get);
                    }),
                TextInput::make('qty_scan')
                    ->label('Aktual')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set, $get) => $calculateOk($set, $get)),
                Hidden::make('total_scan')
                    ->default(0)
                    ->dehydrated(false),

                TextInput::make('no_lot')
                    ->label('Nomor Lot')
                    ->required(),

                TextInput::make('ok')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(true),

                TextInput::make('ng')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set, $get) => $calculateOk($set, $get)),

                TextInput::make('repair')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set, $get) => $calculateOk($set, $get)),

                Textarea::make('keterangan')
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('target'))
            ->columns([
                TextColumn::make('target.jam_awal')
                    ->label('Jam Awal')
                    ->sortable(),
                TextColumn::make('target.jam_akhir')->label('Jam Akhir'),
                TextColumn::make('target.qty')
                    ->label('Planning'),
                TextColumn::make('qty_scan')->label('Aktual'),
                TextColumn::make('no_lot')->label('Number Lot'),
                TextColumn::make('ok')->label('OK'),
                TextColumn::make('ng')->label('NG'),
                TextColumn::make('repair')->label('REP'),
                TextColumn::make('keterangan')->label('Keterangan'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('New Production Report'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
