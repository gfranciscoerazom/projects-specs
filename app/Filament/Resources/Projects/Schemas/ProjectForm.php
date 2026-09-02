<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('audience')
                    ->required(),
                MarkdownEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                MarkdownEditor::make('conventions')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
