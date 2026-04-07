<?php

namespace App\Filament\Resources\RejectReports;

use App\Filament\Resources\RejectReports\Pages\CreateRejectReport;
use App\Filament\Resources\RejectReports\Pages\EditRejectReport;
use App\Filament\Resources\RejectReports\Pages\ListRejectReports;
use App\Filament\Resources\RejectReports\Schemas\RejectReportForm;
use App\Filament\Resources\RejectReports\Tables\RejectReportsTable;
use App\Models\RejectReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RejectReports\RelationManagers\TotalProduksiRelationManager;
use App\Filament\Resources\RejectReports\RelationManagers\ProcessesRelationManager;
use App\Filament\Resources\RejectReports\RelationManagers\RejectReportDetailsRelationManager;


class RejectReportResource extends Resource
{
    protected static ?string $model = RejectReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'full_title';

    public static function form(Schema $schema): Schema
    {
        return RejectReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RejectReportsTable::configure($table); // disini
    }

    public static function getRelations(): array
    {
        return [
            ProcessesRelationManager::class,
            RejectReportDetailsRelationManager::class,
            TotalProduksiRelationManager::class,

        ];
    }

    // Untuk Menghitung Total Reject dan Total Proses di Query Eloquent
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withSum('details as total_reject', 'qty_reject')
            ->withSum('processes', 'qty_proses');
    }


    public static function getPages(): array
    {
        return [
            'index' => ListRejectReports::route('/'),
            'create' => CreateRejectReport::route('/create'),
            'edit' => EditRejectReport::route('/{record}/edit'),
        ];
    }
}
