<?php

namespace App\Filament\Resources\WaarnemingResource\Pages;

use App\Filament\Resources\WaarnemingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWaarnemings extends ListRecords
{
    protected static string $resource = WaarnemingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
