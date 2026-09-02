<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\Project\ProjectStatus;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::getForm());
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            TextInput::make('audience')
                ->required(),
            Select::make('status')
                ->options(ProjectStatus::class)
                ->default(ProjectStatus::ACTIVE)
                ->selectablePlaceholder(false)
                ->required(),
            MarkdownEditor::make('description')
                ->required()
                ->columnSpanFull(),
            MarkdownEditor::make('conventions')
                ->required()
                ->columnSpanFull(),
        ];
    }
}
