<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\NamePart;
use BackedEnum;
use Illuminate\Support\Collection;

class Guiden extends Page
{
    protected string $view = 'filament.pages.guiden';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tv';
    protected static ?string $navigationLabel = 'Guiden';

    protected static ?string $title = 'Guiden Part Visual';



    public Collection $parts;

    public function mount(): void
    {
        $this->parts = NamePart::query()
            ->select('id', 'part_name', 'part_image')
            ->whereNotNull('part_image')
            ->get();
    }
}
