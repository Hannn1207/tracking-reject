<?php

namespace App\Filament\Resources\NameParts;

use App\Filament\Resources\NameParts\Pages\CreateNamePart;
use App\Filament\Resources\NameParts\Pages\EditNamePart;
use App\Filament\Resources\NameParts\Pages\ListNameParts;
use App\Filament\Resources\NameParts\Schemas\NamePartForm;
use App\Filament\Resources\NameParts\Tables\NamePartsTable;
use App\Models\NamePart;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Support\Facades\Auth;

class NamePartResource extends Resource
{
    protected static ?string $model = NamePart::class;
    protected static ?string $navigationLabel = 'Master Part';
    protected static ?string $pluralModelLabel = 'Name Part ';
    protected static string |UnitEnum|null  $navigationGroup = 'Master Data Visual';
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role !== 'operator';
    }
    protected static ?int $navigationSort = 1;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name_parts';

    public static function form(Schema $schema): Schema
    {
        return NamePartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NamePartsTable::configure($table);
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
            'index' => ListNameParts::route('/'),
            'create' => CreateNamePart::route('/create'),
            'edit' => EditNamePart::route('/{record}/edit'),
        ];
    }
}
