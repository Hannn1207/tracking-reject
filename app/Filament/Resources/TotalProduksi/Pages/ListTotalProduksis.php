<?php

namespace App\Filament\Resources\TotalProduksi\Pages;

use App\Filament\Resources\TotalProduksi\TotalProduksiResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListTotalProduksis extends ListRecords
{
    protected static string $resource = TotalProduksiResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
