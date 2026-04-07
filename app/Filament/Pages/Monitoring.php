<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use App\Filament\Widgets\MonitoringMeja;

class Monitoring extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tv';

    public function getHeaderWidgets(): array
    {
        return [
            MonitoringMeja::class,

        ];
    }
}
