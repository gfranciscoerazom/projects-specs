<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\Project\ProjectStatus;
use App\Filament\Resources\Technologies\Schemas\TechnologyForm;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

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
            ])
                ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                     <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                BLADE)))
                ->persistStepInQueryString()
                ->columnSpanFull(),
        ];
    }
}
