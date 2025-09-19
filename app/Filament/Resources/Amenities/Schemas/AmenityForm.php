<?php

namespace App\Filament\Resources\Amenities\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AmenityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
              TextInput::make('name')->required()->maxLength(255),
            TextInput::make('slug')
                ->disabled()
                ->dehydrateStateUsing(fn ($state, $get) => $state ?: Str::slug($get('name'))),
            Select::make('category')
                ->options([
                    'Interior' => 'Interior',
                    'Exterior' => 'Exterior',
                    'Safety' => 'Safety',
                    'Accessibility' => 'Accessibility',
                    'Technology' => 'Technology',
                ])->searchable(),
            TextInput::make('icon')->placeholder('heroicon-o-home'),
            TextInput::make('order_column')->numeric()->default(0),
            KeyValue::make('meta')->columnSpanFull(),
            ]);
    }
}
