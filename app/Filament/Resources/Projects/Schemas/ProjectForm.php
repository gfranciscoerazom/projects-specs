<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\Feature\FeaturePriority;
use App\Enums\Feature\FeatureStatus;
use App\Enums\Feature\FeatureType;
use App\Enums\Project\ProjectStatus;
use App\Filament\Resources\Technologies\Schemas\TechnologyForm;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
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
                        MarkdownEditor::make('conventions')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('technologies')
                            ->multiple()
                            ->relationship('technologies', 'name')
                            ->createOptionForm(TechnologyForm::getForm())
                            ->columnSpanFull(),
                    ]),
                Step::make('Features')
                    ->description('Specify the features for the project.')
                    ->components([
                        Repeater::make('features')
                            ->relationship()
                            ->components(self::getFeaturesForm())
                            ->orderColumn('sort')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->cloneable()
                            ->live()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->columnSpanFull(),
                    ]),
            ]),
        ];
    }

    public static function getFeaturesForm(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            MarkdownEditor::make('description')
                ->required(),
            MarkdownEditor::make('plan')
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
        ];
    }
}
