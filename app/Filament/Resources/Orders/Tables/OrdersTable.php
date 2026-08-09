<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('total_pages')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('copies')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('binding_type')
                    ->searchable(),
                TextColumn::make('urgency_level')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estimated_duration_minutes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('priority_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pickup_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
