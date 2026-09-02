<?php

namespace App\Filament\Resources\Technologies\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechnologyForm
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
            MarkdownEditor::make('conventions')
                ->required()
                ->columnSpanFull(),
        ];
    }
}
