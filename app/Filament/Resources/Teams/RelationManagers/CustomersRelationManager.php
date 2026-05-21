<?php

declare(strict_types=1);

namespace App\Filament\Resources\Teams\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CustomersRelationManager extends RelationManager
{
    protected static string $relationship = 'customers';

    protected static ?string $title = 'Customers';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->modifyQueryUsing(fn ($query) => $query->withCount('licenseKeys'))
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('company')
                    ->label('Company')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('license_keys_count')
                    ->label('Keys')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('email', 'asc');
    }
}
