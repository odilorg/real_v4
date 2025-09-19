<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Models\User;
use App\Enums\HeatingType;
use App\Enums\ParkingType;
use App\Enums\PropertyType;
use Filament\Schemas\Schema;
use App\Enums\PropertyStatus;
use App\Enums\FurnishingLevel;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Section::make('Basics')->schema([
                Select::make('owner_id')
                    ->label('Owner')
                    ->options(User::query()->pluck('name','id'))
                    ->searchable()->required(),
                TextInput::make('title')->required()->maxLength(255),
                Textarea::make('description')->rows(4)->columnSpanFull(),
                Grid::make(3)->schema([
                    Select::make('property_type')
                        ->options(collect(PropertyType::cases())->mapWithKeys(fn($c)=>[$c->value=>ucwords(str_replace('_',' ',$c->value))])->all())
                        ->required(),
                    Select::make('status')
                        ->options(collect(PropertyStatus::cases())->mapWithKeys(fn($c)=>[$c->value=>ucwords(str_replace('_',' ',$c->value))])->all())
                        ->required()->default(PropertyStatus::DRAFT->value),
                    TextInput::make('ownership_type')->placeholder('freehold / leasehold'),
                ]),
            ])->columns(2),
            Section::make('Specs')->schema([
                Grid::make(6)->schema([
                    TextInput::make('year_built')->numeric()->minValue(1800)->maxValue(2100),
                    TextInput::make('area_total')->numeric()->step('0.01'),
                    TextInput::make('area_living')->numeric()->step('0.01'),
                    TextInput::make('bedrooms')->numeric()->minValue(0),
                    TextInput::make('bathrooms')->numeric()->step('0.1'),
                    TextInput::make('floors')->numeric()->minValue(0),
                    TextInput::make('floor_no')->numeric()->minValue(0),
                ]),
                Grid::make(3)->schema([
                    Select::make('parking')
                        ->options(collect(ParkingType::cases())->mapWithKeys(fn($c)=>[$c->value=>ucwords($c->value)])->all())->nullable(),
                    Select::make('heating')
                        ->options(collect(HeatingType::cases())->mapWithKeys(fn($c)=>[$c->value=>ucwords($c->value)])->all())->nullable(),
                    Select::make('furnishing')
                        ->options(collect(FurnishingLevel::cases())->mapWithKeys(fn($c)=>[$c->value=>ucwords($c->value)])->all())->nullable(),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('orientation')->maxLength(5)->placeholder('N/NE/...'),
                    TextInput::make('energy_class')->maxLength(5)->placeholder('A/B/C...'),
                    KeyValue::make('utilities')->keyLabel('key')->valueLabel('value'),
                ]),
            ]),
            Section::make('Location')->schema([
                Grid::make(3)->schema([
                    TextInput::make('country'),
                    TextInput::make('city'),
                    TextInput::make('district'),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('street')->columnSpan(2),
                    TextInput::make('house_no'),
                ]),
                Grid::make(3)->schema([
                    TextInput::make('postal_code'),
                    TextInput::make('lat')->numeric()->step('0.0000001'),
                    TextInput::make('lng')->numeric()->step('0.0000001'),
                ]),
                DateTimePicker::make('published_at')->native(false),
            ]),
            ])->columns(1);
    }
}
