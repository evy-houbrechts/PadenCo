<?php

namespace App\Filament\Resources\WaarnemingResource\Pages;

use App\Filament\Resources\WaarnemingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWaarneming extends EditRecord
{
    protected static string $resource = WaarnemingResource::class;
    protected static ?string $title = 'Invoer bewerken';


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
