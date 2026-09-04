<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Enums\Project\ProjectStatus;
use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->icon(Heroicon::OutlinedSquare3Stack3d)
                ->badge(Project::query()->count())
                ->deferBadge(),
            'Active' => Tab::make()
                ->icon(Heroicon::OutlinedCheckCircle)
                ->badge(Project::query()->where('status', ProjectStatus::ACTIVE)->count())
                ->badgeColor(ProjectStatus::ACTIVE->getColor())
                ->deferBadge()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ProjectStatus::ACTIVE)),
            'Inactive' => Tab::make()
                ->icon(Heroicon::OutlinedPauseCircle)
                ->badge(Project::query()->whereNot('status', ProjectStatus::ACTIVE)->count())
                ->badgeColor(ProjectStatus::CANCELLED->getColor())
                ->deferBadge()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNot('status', ProjectStatus::ACTIVE)),
        ];
    }

    public function getDefaultActiveTab(): int|string|null
    {
        return 'Active';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
