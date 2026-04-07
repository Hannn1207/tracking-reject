<?php

namespace App\Filament\Resources\RejectTypes\Pages;

use App\Filament\Resources\RejectTypes\RejectTypeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;


class CreateRejectType extends CreateRecord
{
    protected static string $resource = RejectTypeResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();;

        return $data;
    }
}
