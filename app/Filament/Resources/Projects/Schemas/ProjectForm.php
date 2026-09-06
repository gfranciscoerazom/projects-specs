<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\Feature\FeaturePriority;
use App\Enums\Feature\FeatureStatus;
use App\Enums\Feature\FeatureType;
use App\Enums\PlanTask\PlanTaskStatus;
use App\Enums\Project\ProjectStatus;
use App\Filament\Resources\Technologies\Schemas\TechnologyForm;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

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
            Wizard::make([
                Step::make('Basic Information')
                    ->description('Provide the basic information for the project.')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('audience')
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ProjectStatus::class)
                            ->default(ProjectStatus::ACTIVE)
                            ->inline()
                            ->columnSpanFull()
                            ->required(),
                        MarkdownEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Step::make('Conventions & Technologies')
                    ->description('Specify the conventions and technologies for the project.')
                    ->components([
                        Select::make('technologies')
                            ->multiple()
                            ->relationship('technologies', 'name')
                            ->createOptionForm(TechnologyForm::getForm())
                            ->required()
                            ->columnSpanFull(),
                        MarkdownEditor::make('conventions')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Step::make('Features')
                    ->description('Specify the features for the project.')
                    ->components([
                        Repeater::make('features')
                            ->defaultItems(1)
                            ->relationship()
                            ->components(self::getFeaturesForm())
                            ->orderColumn('sort')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->cloneable()
                            ->live()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->minItems(1)
                            ->columnSpanFull(),
                    ]),
            ]),
        ];
    }

    public static function getFeaturesForm(): array
    {
        return [
            Tabs::make('Features')
                ->vertical()
                ->tabs([
                    Tab::make('General')
                        ->icon(Heroicon::DocumentCheck)
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            MarkdownEditor::make('description')
                                ->required(),
                            ToggleButtons::make('status')
                                ->options(FeatureStatus::class)
                                ->default(FeatureStatus::PENDING)
                                ->inline()
                                ->required(),
                            ToggleButtons::make('priority')
                                ->options(FeaturePriority::class)
                                ->default(FeaturePriority::LOW)
                                ->inline()
                                ->required(),
                            ToggleButtons::make('type')
                                ->options(FeatureType::class)
                                ->default(FeatureType::FEATURE)
                                ->inline()
                                ->required(),
                        ]),
                    Tab::make('Acceptance Criterias')
                        ->icon(Heroicon::ShieldCheck)
                        ->schema([
                            Repeater::make('acceptanceCriterias')
                                ->relationship()
                                ->components(self::getAcceptanceCriteriaForm())
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->cloneable()
                                ->live()
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                ->columnSpanFull(),
                        ]),
                    Tab::make('User Stories')
                        ->icon(Heroicon::User)
                        ->schema([
                            Repeater::make('userStories')
                                ->relationship()
                                ->components(self::getUserStoriesForm())
                                ->reorderable()
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->cloneable()
                                ->live()
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                ->columnSpanFull(),
                        ]),
                    Tab::make('Plan Tasks')
                        ->icon(Heroicon::CheckBadge)
                        ->schema([
                            MarkdownEditor::make('plan')
                                ->required(),
                            Repeater::make('planTasks')
                                ->relationship()
                                ->components(self::getPlanTasksForm())
                                ->orderColumn('sort')
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->cloneable()
                                ->live()
                                ->itemLabel(fn (array $state): ?string => $state['task'] ?? null)
                                ->columnSpanFull(),
                        ]),
                ]),
        ];
    }

    public static function getAcceptanceCriteriaForm(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            MarkdownEditor::make('description')
                ->required(),
            Toggle::make('is_met')
                ->default(false),
        ];
    }

    public static function getUserStoriesForm(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            MarkdownEditor::make('story')
                ->required(),
        ];
    }

    public static function getPlanTasksForm(): array
    {
        return [
            TextInput::make('task')
                ->required(),
            MarkdownEditor::make('description')
                ->required(),
            ToggleButtons::make('status')
                ->options(PlanTaskStatus::class)
                ->default(PlanTaskStatus::PENDING)
                ->inline()
                ->required(),
        ];
    }
}
