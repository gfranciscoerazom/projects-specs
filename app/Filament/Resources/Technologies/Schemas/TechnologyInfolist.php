<?php

namespace App\Filament\Resources\Technologies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TechnologyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('conventions')
                    ->markdown()
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
