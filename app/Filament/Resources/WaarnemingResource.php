<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaarnemingResource\Pages;
use App\Models\Waarneming;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class WaarnemingResource extends Resource
{
    protected static ?string $model = Waarneming::class;
    protected static ?string $label = 'Invoer';
protected static ?string $pluralLabel = 'Waarnemingen';
protected static ?string $navigationLabel = 'Waarnemingen';


    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationGroup = 'Beheer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('datum')->required(),
                Forms\Components\Select::make('tijd_id')->relationship('tijd', 'moment')->required(),
                Forms\Components\Select::make('straat_id')->relationship('straat', 'naam')->required(),
                Forms\Components\Select::make('user_id')->relationship('user', 'name')->required(),
                Forms\Components\Repeater::make('aantallen')
                ->label('Soorten en aantallen')
                ->relationship('aantalWaarnemingen') // relatie in je model
                ->schema([
                    Forms\Components\Select::make('soort_id')
                        ->label('Soort')
                        ->relationship('soort', 'naam')
                        ->required(),
            
                    Forms\Components\Select::make('categorie_id')
                        ->label('Categorie')
                        ->relationship('categorie', 'label')
                        ->required(),
            
                    Forms\Components\TextInput::make('aantal')
                        ->label('Aantal')
                        ->numeric()
                        ->required(),
                ])
                ->createItemButtonLabel('')
                ->columns(3),
            ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('datum')->sortable()->date(),
                Tables\Columns\TextColumn::make('tijd.moment')->label('Tijd'),
                Tables\Columns\TextColumn::make('straat.naam')->label('Straat'),
                Tables\Columns\TextColumn::make('user.name')->label('Gebruiker')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')->label('Gebruiker')->relationship('user', 'name'),
                Tables\Filters\SelectFilter::make('tijd_id')->label('Tijd')->relationship('tijd', 'moment'),
                Tables\Filters\SelectFilter::make('straat_id')->label('Straat')->relationship('straat', 'naam'),
                Tables\Filters\Filter::make('datum')
                    ->form([
                        Forms\Components\DatePicker::make('datum')->label('Specifieke dag'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['datum'], fn ($q, $v) => $q->whereDate('datum', $v));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWaarnemings::route('/'),
            'create' => Pages\CreateWaarneming::route('/create'),
            'edit' => Pages\EditWaarneming::route('/{record}/edit'),
        ];
    }
}
