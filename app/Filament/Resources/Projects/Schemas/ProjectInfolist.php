<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Actions\AcceptanceCriteria\MarkAsIsMetAcceptanceCriteria;
use App\Actions\Feature\ChangeToCompletedFeature;
use App\Actions\Feature\ChangeToFailedFeature;
use App\Actions\Feature\ChangeToInProgressFeature;
use App\Actions\Feature\ChangeToPendingFeature;
use App\Actions\PlanTask\ChangeToCompletedPlanTask;
use App\Actions\PlanTask\ChangeToFailedPlanTask;
use App\Actions\PlanTask\ChangeToInProgressPlanTask;
use App\Actions\PlanTask\ChangeToPendingPlanTask;
use App\Enums\Feature\FeatureStatus;
use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\AcceptanceCriteria;
use App\Models\Feature;
use App\Models\PlanTask;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('audience'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('description')
                    ->markdown()
                    ->columnSpanFull(),
                TextEntry::make('conventions')
                    ->markdown()
                    ->columnSpanFull(),
                TextEntry::make('technologies.name')
                    ->label('Technologies')
                    ->badge()
                    ->columnSpanFull(),
                RepeatableEntry::make('features')
                    ->schema([
                        Tabs::make('Features')
                            ->vertical()
                            ->tabs([
                                Tab::make('General')
                                    ->icon(Heroicon::DocumentCheck)
                                    ->columns(3)
                                    ->schema(self::getFeatureSchema()),
                                Tab::make('Acceptance Criterias')
                                    ->icon(Heroicon::ShieldCheck)
                                    ->schema(self::getAcceptanceCriteriaSchema()),
                                Tab::make('User Stories')
                                    ->icon(Heroicon::User)
                                    ->schema(self::getUserStoriesSchema()),
                                Tab::make('Plan Tasks')
                                    ->icon(Heroicon::CheckBadge)
                                    ->schema(self::getPlanTasksSchema()),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function getFeatureSchema(): array
    {
        return [
            TextEntry::make('name')
                ->columnSpanFull(),
            TextEntry::make('description')
                ->markdown()
                ->columnSpanFull(),
            TextEntry::make('status')
                ->badge()
                ->beforeLabel([
                    ActionGroup::make(self::getFeatureActions()),
                ]),
            TextEntry::make('priority')
                ->badge(),
            TextEntry::make('type')
                ->badge(),
        ];
    }

    private static function getAcceptanceCriteriaSchema(): array
    {
        return [
            RepeatableEntry::make('acceptanceCriterias')
                ->schema([
                    TextEntry::make('name'),
                    TextEntry::make('description')
                        ->markdown()
                        ->columnSpanFull(),
                    IconEntry::make('is_met')
                        ->afterLabel(self::getAcceptanceCriteriaAction()),
                ])
                ->columnSpanFull(),
        ];
    }

    private static function getUserStoriesSchema(): array
    {
        return [
            RepeatableEntry::make('userStories')
                ->schema([
                    TextEntry::make('name'),
                    TextEntry::make('story')
                        ->markdown()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    private static function getPlanTasksSchema(): array
    {
        return [
            TextEntry::make('plan')
                ->markdown()
                ->columnSpanFull(),
            RepeatableEntry::make('planTasks')
                ->schema([
                    TextEntry::make('task'),
                    TextEntry::make('description')
                        ->markdown()
                        ->columnSpanFull(),
                    TextEntry::make('status')
                        ->badge()
                        ->beforeLabel([
                            ActionGroup::make(self::getPlanTaskActions()),
                        ]),
                ])
                ->columnSpanFull(),
        ];
    }

    private static function getFeatureActions(): array
    {
        return [
            Action::make('Change to '.FeatureStatus::PENDING->getLabel())
                ->action(fn (Feature $feature, ChangeToPendingFeature $handle) => $handle($feature))
                ->icon(FeatureStatus::PENDING->getIcon())
                ->color(FeatureStatus::PENDING->getColor())
                ->hidden(fn (Feature $record) => $record->status === FeatureStatus::PENDING)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Feature status changed to '.FeatureStatus::PENDING->getLabel())
                        ->body('The feature status has been successfully changed to pending.')
                        ->send()
                ),
            Action::make('Change to '.FeatureStatus::IN_PROGRESS->getLabel())
                ->action(fn (Feature $feature, ChangeToInProgressFeature $handle) => $handle($feature))
                ->icon(FeatureStatus::IN_PROGRESS->getIcon())
                ->color(FeatureStatus::IN_PROGRESS->getColor())
                ->hidden(fn (Feature $record) => $record->status === FeatureStatus::IN_PROGRESS)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Feature status changed to '.FeatureStatus::IN_PROGRESS->getLabel())
                        ->body('The feature status has been successfully changed to in progress.')
                        ->send()
                ),
            Action::make('Change to '.FeatureStatus::COMPLETED->getLabel())
                ->action(fn (Feature $feature, ChangeToCompletedFeature $handle) => $handle($feature))
                ->icon(FeatureStatus::COMPLETED->getIcon())
                ->color(FeatureStatus::COMPLETED->getColor())
                ->hidden(fn (Feature $record) => $record->status === FeatureStatus::COMPLETED)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Feature status changed to '.FeatureStatus::COMPLETED->getLabel())
                        ->body('The feature status has been successfully changed to completed.')
                        ->send()
                ),
            Action::make('Change to '.FeatureStatus::FAILED->getLabel())
                ->action(fn (Feature $feature, ChangeToFailedFeature $handle) => $handle($feature))
                ->icon(FeatureStatus::FAILED->getIcon())
                ->color(FeatureStatus::FAILED->getColor())
                ->hidden(fn (Feature $record) => $record->status === FeatureStatus::FAILED)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Feature status changed to '.FeatureStatus::FAILED->getLabel())
                        ->body('The feature status has been successfully changed to failed.')
                        ->send()
                ),
        ];
    }

    private static function getAcceptanceCriteriaAction(): Action
    {
        return Action::make('Mark as Met')
            ->action(fn (AcceptanceCriteria $criteria, MarkAsIsMetAcceptanceCriteria $handle) => $handle($criteria))
            ->icon(Heroicon::Check)
            ->color('success')
            ->hidden(fn (AcceptanceCriteria $record) => $record->is_met)
            ->after(
                fn () => Notification::make()
                    ->success()
                    ->title('Acceptance Criteria marked as met')
                    ->body('The acceptance criteria has been successfully marked as met.')
                    ->send()
            );
    }

    private static function getPlanTaskActions(): array
    {
        return [
            Action::make('Change to '.PlanTaskStatus::PENDING->getLabel())
                ->action(fn (PlanTask $planTask, ChangeToPendingPlanTask $handle) => $handle($planTask))
                ->icon(PlanTaskStatus::PENDING->getIcon())
                ->color(PlanTaskStatus::PENDING->getColor())
                ->hidden(fn (PlanTask $record) => $record->status === PlanTaskStatus::PENDING)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Plan task status changed to '.PlanTaskStatus::PENDING->getLabel())
                        ->body('The plan task status has been successfully changed to pending.')
                        ->send()
                ),
            Action::make('Change to '.PlanTaskStatus::IN_PROGRESS->getLabel())
                ->action(fn (PlanTask $planTask, ChangeToInProgressPlanTask $handle) => $handle($planTask))
                ->icon(PlanTaskStatus::IN_PROGRESS->getIcon())
                ->color(PlanTaskStatus::IN_PROGRESS->getColor())
                ->hidden(fn (PlanTask $record) => $record->status === PlanTaskStatus::IN_PROGRESS)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Plan task status changed to '.PlanTaskStatus::IN_PROGRESS->getLabel())
                        ->body('The plan task status has been successfully changed to in progress.')
                        ->send()
                ),
            Action::make('Change to '.PlanTaskStatus::COMPLETED->getLabel())
                ->action(fn (PlanTask $planTask, ChangeToCompletedPlanTask $handle) => $handle($planTask))
                ->icon(PlanTaskStatus::COMPLETED->getIcon())
                ->color(PlanTaskStatus::COMPLETED->getColor())
                ->hidden(fn (PlanTask $record) => $record->status === PlanTaskStatus::COMPLETED)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Plan task status changed to '.PlanTaskStatus::COMPLETED->getLabel())
                        ->body('The plan task status has been successfully changed to completed.')
                        ->send()
                ),
            Action::make('Change to '.PlanTaskStatus::FAILED->getLabel())
                ->action(fn (PlanTask $planTask, ChangeToFailedPlanTask $handle) => $handle($planTask))
                ->icon(PlanTaskStatus::FAILED->getIcon())
                ->color(PlanTaskStatus::FAILED->getColor())
                ->hidden(fn (PlanTask $record) => $record->status === PlanTaskStatus::FAILED)
                ->after(
                    fn () => Notification::make()
                        ->success()
                        ->title('Plan task status changed to '.PlanTaskStatus::FAILED->getLabel())
                        ->body('The plan task status has been successfully changed to failed.')
                        ->send()
                ),
        ];
    }
}
