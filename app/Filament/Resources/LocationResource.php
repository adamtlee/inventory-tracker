<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;


    protected static ?string $navigationLabel = 'Locations';

    protected static ?string $modelLabel = 'Location';

    protected static ?string $pluralModelLabel = 'Locations';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('location_id')
                    ->label('Location ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., LOC-001')
                    ->helperText('Unique identifier for this location'),
                
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->placeholder('e.g., Main Tool Room, Maintenance Shed')
                    ->helperText('Name of the location'),
                
                Forms\Components\TextInput::make('bin')
                    ->placeholder('e.g., Shelf A1, Bin 3')
                    ->helperText('Specific bin or shelf within the location'),
                
                Forms\Components\Textarea::make('description')
                    ->placeholder('Additional location details')
                    ->rows(3)
                    ->helperText('Any additional information about this location'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('location_id')
                    ->label('Location ID')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('bin')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('assets_count')
                    ->label('Assets Count')
                    ->counts('assets')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'view' => Pages\ViewLocation::route('/{record}'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
