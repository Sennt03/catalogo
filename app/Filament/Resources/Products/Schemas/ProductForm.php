<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->columns(2)
                            ->components([
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(250)
                                    ->columnSpanFull(),

                                Select::make('category_id')
                                    ->label('Categoría')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('sort_order')
                                    ->label('Orden')
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Tab::make('Descripción')
                            ->components([
                                RichEditor::make('description')
                                    ->label('Descripción')
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('short_description')
                                    ->label('Descripción corta')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Estado')
                            ->columns(3)
                            ->components([
                                Toggle::make('is_active')
                                    ->label('Activo')
                                    ->default(true),

                                Toggle::make('is_featured')
                                    ->label('Destacado')
                                    ->default(false),

                                Toggle::make('has_variants')
                                    ->label('Tiene variantes')
                                    ->default(false)
                                    ->live(),
                            ]),

                        Tab::make('Variantes')
                            ->components([
                                Repeater::make('variants')
                                    ->relationship('variants')
                                    ->orderColumn('sort_order')
                                    ->defaultItems(0)
                                    ->hidden(fn (Get $get): bool => ! $get('has_variants'))
                                    ->columns(4)
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get): ?array {
                                        if (! $get('has_variants')) {
                                            return null;
                                        }

                                        return $data;
                                    })
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nombre')
                                            ->required()
                                            ->maxLength(250),

                                        ColorPicker::make('color_code')
                                            ->label('Color')
                                            ->nullable(),

                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->nullable()
                                            ->maxLength(100),

                                        TextInput::make('price')
                                            ->label('Precio')
                                            ->numeric()
                                            ->required()
                                            ->default(0),

                                        TextInput::make('compare_at_price')
                                            ->label('Precio comparación')
                                            ->numeric()
                                            ->nullable(),

                                        TextInput::make('stock')
                                            ->label('Stock')
                                            ->numeric()
                                            ->default(0),

                                        Toggle::make('is_active')
                                            ->label('Activa')
                                            ->default(true),

                                        TextInput::make('sort_order')
                                            ->label('Orden')
                                            ->numeric()
                                            ->default(0),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
