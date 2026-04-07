<?php

namespace App\Filament\Resources\RejectReportDetails;

use App\Filament\Resources\RejectReportDetails\Pages\CreateRejectReportDetail;
use App\Filament\Resources\RejectReportDetails\Pages\EditRejectReportDetail;
use App\Filament\Resources\RejectReportDetails\Pages\ListRejectReportDetails;
use App\Filament\Resources\RejectReportDetails\Schemas\RejectReportDetailForm;
use App\Filament\Resources\RejectReportDetails\Tables\RejectReportDetailsTable;
use App\Models\RejectReportDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RejectReportDetailResource extends Resource
{
    protected static ?string $model = RejectReportDetail::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = '';

    public static function form(Schema $schema): Schema
    {
        return RejectReportDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RejectReportDetailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRejectReportDetails::route('/'),
            'create' => CreateRejectReportDetail::route('/create'),
            'edit' => EditRejectReportDetail::route('/{record}/edit'),
        ];
    }
}
