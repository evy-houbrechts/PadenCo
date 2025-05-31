<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaResource\Pages;
use App\Models\Agenda;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class AgendaResource extends Resource
{
    protected static ?string $model = Agenda::class;

    protected static ?string $label = 'Agenda';
protected static ?string $pluralLabel = 'Agenda\'s';
protected static ?string $navigationLabel = 'Agenda\'s';



    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Beheer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('datum')->required(),
                Forms\Components\Select::make('tijd_id')->relationship('tijd', 'moment')->required(),
                Forms\Components\Select::make('straat_id')->relationship('straat', 'naam')->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Gebruiker')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('datum')->sortable()->date(),
                Tables\Columns\TextColumn::make('tijd.moment')->label('Tijd'),
                Tables\Columns\TextColumn::make('straat.naam')->label('Straat'),
                Tables\Columns\TextColumn::make('user.name')->label('Gebruiker')->sortable()->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Filter op gebruiker')
                    ->relationship('user', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }
}
