<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
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

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;


    protected static ?string $navigationLabel = 'Assets';

    protected static ?string $modelLabel = 'Asset';

    protected static ?string $pluralModelLabel = 'Assets';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('asset_id')
                    ->label('Asset ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., TOOL-001, Shovel-A')
                    ->helperText('Unique identifier for this specific asset'),
                
                Forms\Components\TextInput::make('item')
                    ->required()
                    ->placeholder('e.g., Shovel, Power Drill, Ladder')
                    ->helperText('Name of the item'),
                
                Forms\Components\TextInput::make('item_code')
                    ->label('Item Code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., SHOVEL-001')
                    ->helperText('Human-readable identifier for quick reference'),
                
                Forms\Components\TextInput::make('belongs_to')
                    ->label('Belongs To')
                    ->required()
                    ->placeholder('e.g., Maintenance, Garden, Construction')
                    ->helperText('Department or team that owns this asset'),
                
                Forms\Components\Select::make('condition')
                    ->required()
                    ->options([
                        'Excellent' => 'Excellent',
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                        'Worn' => 'Worn',
                        'Damaged' => 'Damaged',
                        'Out of Service' => 'Out of Service',
                    ])
                    ->default('Good'),
                
                Forms\Components\Select::make('location_id')
                    ->label('Location')
                    ->relationship('location', 'location')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('location_id')
                            ->label('Location ID')
                            ->required()
                            ->unique()
                            ->placeholder('e.g., LOC-001'),
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->placeholder('e.g., Main Tool Room'),
                        Forms\Components\TextInput::make('bin')
                            ->placeholder('e.g., Shelf A1'),
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Additional location details'),
                    ]),
                
                Forms\Components\Textarea::make('comments')
                    ->placeholder('Any permanent notes about this item')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_id')
                    ->label('Asset ID')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('item')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('item_code')
                    ->label('Item Code')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('belongs_to')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('condition')
                    ->badge()
                    ->colors([
                        'success' => 'Excellent',
                        'success' => 'Good',
                        'warning' => 'Fair',
                        'warning' => 'Worn',
                        'danger' => 'Damaged',
                        'danger' => 'Out of Service',
                    ]),
                
                Tables\Columns\TextColumn::make('location.location')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('isCheckedOut')
                    ->label('Status')
                    ->getStateUsing(fn (Asset $record): string => $record->isCheckedOut() ? 'Checked Out' : 'Available')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Available' ? 'success' : 'warning'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('condition')
                    ->options([
                        'Excellent' => 'Excellent',
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                        'Worn' => 'Worn',
                        'Damaged' => 'Damaged',
                        'Out of Service' => 'Out of Service',
                    ]),
                
                Tables\Filters\SelectFilter::make('belongs_to')
                    ->label('Department')
                    ->options(fn (): array => Asset::distinct()->pluck('belongs_to', 'belongs_to')->toArray()),
                
                Tables\Filters\TernaryFilter::make('is_checked_out')
                    ->label('Checkout Status')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('checkouts', fn (Builder $query) => $query->whereNull('date_returned')),
                        false: fn (Builder $query) => $query->whereDoesntHave('checkouts', fn (Builder $query) => $query->whereNull('date_returned')),
                    ),
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
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
