<?php

declare(strict_types=1);

namespace App\Filament\Resources\Teams\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class LicenseKeyTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'licenseKeyTypes';

    protected static ?string $title = 'Key Types';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn ($query) => $query->withCount('licenseKeys'))
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('generator_type')
                    ->label('Generator')
                    ->badge()
                    ->sortable(),
                TextColumn::make('license_keys_count')
                    ->label('Keys')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('name', 'asc');
    }
}
