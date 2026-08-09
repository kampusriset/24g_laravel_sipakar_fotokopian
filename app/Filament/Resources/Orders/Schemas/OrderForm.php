<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('total_pages')
                    ->required()
                    ->numeric(),
                TextInput::make('copies')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('binding_type')
                    ->required(),
                TextInput::make('urgency_level')
                    ->required()
                    ->numeric(),
                TextInput::make('estimated_duration_minutes')
                    ->numeric()
                    ->default(null),
                TextInput::make('priority_score')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('pickup_time'),
                TextInput::make('status')
                    ->required()
                    ->default('Dalam Antrean AI'),
            ]);
    }
}
