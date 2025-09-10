<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckoutResource\Pages;
use App\Models\Checkout;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckoutResource extends Resource
{
    protected static ?string $model = Checkout::class;


    protected static ?string $navigationLabel = 'Checkouts';

    protected static ?string $modelLabel = 'Checkout';

    protected static ?string $pluralModelLabel = 'Checkouts';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('checkout_id')
                    ->label('Checkout ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., CHK-001')
                    ->helperText('Unique identifier for this transaction'),
                
                Forms\Components\Select::make('asset_id')
                    ->label('Asset')
                    ->relationship('asset', 'item')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->asset_id} - {$record->item}")
                    ->helperText('Select the asset being checked out'),
                
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Select the user checking out the asset'),
                
                Forms\Components\TextInput::make('checked_out_by')
                    ->label('Checked Out By')
                    ->required()
                    ->placeholder('Full name of person taking the item')
                    ->helperText('Name of the person who physically took the item'),
                
                Forms\Components\DateTimePicker::make('date_checked_out')
                    ->label('Date Checked Out')
                    ->required()
                    ->default(now())
                    ->helperText('When the item was given out'),
                
                Forms\Components\DateTimePicker::make('date_returned')
                    ->label('Date Returned')
                    ->helperText('When the item was brought back (leave empty if still out)'),
                
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->helperText('Number of items (usually 1 for specific assets)'),
                
                Forms\Components\Textarea::make('checkout_comments')
                    ->label('Checkout Comments')
                    ->placeholder('Notes specific to this checkout transaction')
                    ->rows(3)
                    ->helperText('e.g., "Used for garden project", "Emergency repair"'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('checkout_id')
                    ->label('Checkout ID')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('asset.asset_id')
                    ->label('Asset ID')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('asset.item')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('checked_out_by')
                    ->label('Checked Out By')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_checked_out')
                    ->label('Checked Out')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_returned')
                    ->label('Returned')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('isReturned')
                    ->label('Status')
                    ->getStateUsing(fn (Checkout $record): string => $record->isReturned() ? 'Returned' : 'Out')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Returned' ? 'success' : 'warning'),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('asset_id')
                    ->label('Asset')
                    ->relationship('asset', 'item')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('returned')
                    ->label('Returned Items')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('date_returned')),
                
                Tables\Filters\Filter::make('outstanding')
                    ->label('Outstanding Items')
                    ->query(fn (Builder $query): Builder => $query->whereNull('date_returned')),
                
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('checked_out_from')
                            ->label('Checked Out From'),
                        Forms\Components\DatePicker::make('checked_out_until')
                            ->label('Checked Out Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['checked_out_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_checked_out', '>=', $date),
                            )
                            ->when(
                                $data['checked_out_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_checked_out', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('return')
                    ->label('Mark as Returned')
                    ->color('success')
                    ->visible(fn (Checkout $record): bool => !$record->isReturned())
                    ->form([
                        Forms\Components\DateTimePicker::make('date_returned')
                            ->label('Return Date')
                            ->default(now())
                            ->required(),
                        Forms\Components\Textarea::make('return_notes')
                            ->label('Return Notes')
                            ->placeholder('Any notes about the return condition'),
                    ])
                    ->action(function (Checkout $record, array $data): void {
                        $record->update([
                            'date_returned' => $data['date_returned'],
                        ]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date_checked_out', 'desc');
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
            'index' => Pages\ListCheckouts::route('/'),
            'create' => Pages\CreateCheckout::route('/create'),
            'view' => Pages\ViewCheckout::route('/{record}'),
            'edit' => Pages\EditCheckout::route('/{record}/edit'),
        ];
    }
}
