<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Enums\Project\ProjectStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('audience'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('description')
                    ->wrap()
                    ->lineClamp(2)
                    ->markdown()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('technologies.name')
                    ->label('Technologies')
                    ->badge()
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('conventions')
                    ->wrap()
                    ->lineClamp(2)
                    ->markdown()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->options(ProjectStatus::class),
                SelectFilter::make('technologies')
                    ->relationship('technologies', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->persistFiltersInSession()
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
