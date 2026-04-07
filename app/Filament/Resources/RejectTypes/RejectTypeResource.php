<?php

namespace App\Filament\Resources\RejectTypes;

use App\Filament\Resources\RejectTypes\Pages\CreateRejectType;
use App\Filament\Resources\RejectTypes\Pages\EditRejectType;
use App\Filament\Resources\RejectTypes\Pages\ListRejectTypes;
use App\Filament\Resources\RejectTypes\Schemas\RejectTypeForm;
use App\Filament\Resources\RejectTypes\Tables\RejectTypesTable;
use App\Models\RejectType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RejectTypeResource extends Resource
{
    protected static ?string $model = RejectType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_reject';
    protected static ?string $navigationLabel = 'Master Nama Reject';
    protected static ?string $pluralModelLabel = 'Name Reject ';
    protected static string|UnitEnum|null  $navigationGroup = 'Master Data Visual';
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role !== 'operator';
    }
    protected static ?int $navigationSort = 2;


    public static function form(Schema $schema): Schema
    {
        return RejectTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RejectTypesTable::configure($table);
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
            'index' => ListRejectTypes::route('/'),
            'create' => CreateRejectType::route('/create'),
            'edit' => EditRejectType::route('/{record}/edit'),
        ];
    }
}
