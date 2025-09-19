<?php

namespace App\Filament\Resources\Taxonomies\Schemas;


use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TaxonomyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
              Select::make('type')
                ->options([
                    'property_type' => 'Property Type',
                    'category' => 'Category',
                    'tag' => 'Tag',
                    'city' => 'City',
                    'district' => 'District',
                ])->required()->native(false),
           TextInput::make('name')->required()->maxLength(255),
           TextInput::make('slug')
                ->disabled()
                ->dehydrateStateUsing(fn ($state, $get) => $state ?: Str::slug($get('name'))),
           Select::make('parent_id')
                ->label('Parent')
                ->options(Taxonomy::query()->pluck('name','id'))
                ->searchable()->nullable(),
           TextInput::make('order_column')->numeric()->default(0),
           KeyValue::make('meta')->columnSpanFull(),
            ]);
    }
}
