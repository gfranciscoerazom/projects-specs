<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('star')
                ->label('Fill with factory data')
                ->icon(Heroicon::Star)
                ->visible(app()->isLocal())
                ->action(fn () => $this->form->fill(Project::factory()->definition())),
        ];
    }
}
