<?php

namespace App\Filament\Resources\AgendaResource\Pages;
use App\Filament\Resources\AgendaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditAgenda extends EditRecord
{
    protected static string $resource = AgendaResource::class;
    protected static ?string $title = 'Agenda bewerken';


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
