<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\IconPosition;
use App\Filament\Widgets\ProductionStats;
use App\Filament\Widgets\RejectChart;
use App\Filament\Widgets\ProductionChart;
use App\Filament\Widgets\RejectTrendChart;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Tables\Columns\Column;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    public static ?string $modelLabel = 'Dashboard';
    public function getWidgets(): array
    {
        return [
            ProductionStats::class,
            ProductionChart::class,
            RejectChart::class,
            RejectTrendChart::class,
        ];
    }
}
