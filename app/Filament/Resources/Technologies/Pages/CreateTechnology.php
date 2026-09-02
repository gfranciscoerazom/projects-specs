<?php

namespace App\Filament\Resources\Technologies\Pages;

use App\Filament\Resources\Technologies\TechnologyResource;
use App\Models\Technology;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateTechnology extends CreateRecord
{
    protected static string $resource = TechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('star')
                ->label('Fill with factory data')
                ->icon(Heroicon::Star)
                ->visible(app()->isLocal())
                ->action(fn () => $this->form->fill(Technology::factory()->definition())),
        ];
    }
}
