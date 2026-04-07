<?php

namespace App\Filament\Resources\ProductionReports;

use App\Filament\Resources\ProductionReports\Pages\CreateProductionReport;
use App\Filament\Resources\ProductionReports\Pages\EditProductionReport;
use App\Filament\Resources\ProductionReports\Pages\ListProductionReports;
use App\Filament\Resources\ProductionReports\Schemas\ProductionReportForm;
use App\Filament\Resources\ProductionReports\Tables\ProductionReportsTable;
use App\Filament\Resources\ProductionReports\RelationManagers\LokalDetailRelationManager;
use App\Filament\Resources\ProductionReports\RelationManagers\EksporDetailRelationManager;
use App\Models\ProductionReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductionReportResource extends Resource
{
    protected static ?string $model = ProductionReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;
    protected static ?string $modelLabel = 'Production Report';
    protected static ?string $pluralModelLabel = 'Production Reports';

    protected static ?string $recordTitleAttribute = 'full_title';
    public static function form(Schema $schema): Schema
    {
        return ProductionReportForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        return ProductionReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            LokalDetailRelationManager::class,
            EksporDetailRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductionReports::route('/'),
            'create' => CreateProductionReport::route('/create'),
            'edit' => EditProductionReport::route('/{record}/edit'),
        ];
    }
}
