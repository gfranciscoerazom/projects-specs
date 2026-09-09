<?php

namespace App\Providers\Filament;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class FilamentUiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // When a field has multiple words like "due_date", the label changes from "Due date" to "Due Date".
        Field::configureUsing(function (Field $field) {
            $field->label(
                fn (Component $component) => str($component->getName())
                    ->afterLast('.')
                    ->kebab()
                    ->replace(['-', '_'], ' ')
                    ->ucwords()
            );

            $field->validationAttribute(fn (Component $component) => $component->getLabel());

            return $field;
        });

        // make selects searchable and preloaded by default
        Select::configureUsing(
            fn (Select $field) => $field
                ->searchable()
                ->preload()
        );

        // add sensible min and max so you don't end up with dates like 01/01/0000 or 01/01/3000
        DatePicker::configureUsing(
            fn (DatePicker $datePicker) => $datePicker
                ->minDate(Carbon::createFromDate(1500, 1, 1))
                ->maxDate(now()->addYears(30))
        );

        // US based phone input, adjust for different countries
        // SI NO ESTOY MAL HAY UN PLUGIN PARA ESTO
        // TextInput::macro(
        //     'phone',
        //     fn () => $this->mask('(999) 999-9999')
        //         ->prefixIcon('heroicon-o-phone')
        //         ->tel()
        //         ->minLength(14)
        //         ->maxLength(14)
        //         ->validationMessages([
        //             'min' => 'Please enter a valid phone number including area code.',
        //         ])
        // );

        // if an action is a modal, do not close by clicking away and default to slideover
        Action::configureUsing(
            fn (Action $action) => $action
                ->closeModalByClickingAway(false)
                ->slideOver()
        );

        // capitalize the model name in a create action label
        CreateAction::configureUsing(
            fn (CreateAction $action) => $action
                ->label(fn (): string => __('filament-actions::create.single.label', ['label' => ucwords($action->getModelLabel())]))
        );

        // various table presets
        Table::configureUsing(
            fn (Table $table) => $table
                ->reorderableColumns()
                ->columnManagerColumns(2)
                ->columnManagerTriggerAction(fn (Action $action) => $action->button()->label('Columns'))
                ->filtersTriggerAction(fn (Action $action) => $action->button()->label('Filters')->slideOver()->closeModalByClickingAway(true))
                ->filtersFormWidth(Width::Small)
                ->paginationPageOptions([10, 25, 50])
        );

        // allow any column to be toggled
        Column::configureUsing(fn (Column $column) => $column->toggleable());

        // default each text column to be sortable and searchable
        TextColumn::configureUsing(
            fn (TextColumn $textColumn) => $textColumn
                ->searchable() // BE CAREFUL, you may end up with 500 errors
                ->sortable() // BE CAREFUL, you may end up with 500 errors
        );

        // make notifications last 10 seconds by default
        Notification::configureUsing(fn (Notification $notification) => $notification->duration(10000));

        // use your preferred date displays
        Schema::configureUsing(
            fn (Schema $schema) => $schema
                ->defaultDateDisplayFormat('m/d/Y')
                ->defaultDateTimeDisplayFormat('h:i A')
                ->defaultTimeDisplayFormat('m/d/Y h:i A')
        );

        // Configure the RichEditor component
        RichEditor::configureUsing(
            fn (RichEditor $richEditor) => $richEditor
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'link'],
                    ['h2', 'h3'],
                    ['alignStart', 'alignCenter', 'alignEnd'],
                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                    ['undo', 'redo'],
                ])
        );

        // make wizards persist the current step in the query string and have a submit button
        Wizard::configureUsing(
            fn (Wizard $wizard) => $wizard
                ->persistStepInQueryString()
                ->columnSpanFull()
                ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                     <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                BLADE)))
        );

        // make repeaters collapsible, cloneable, and have a minimum of 1 item
        Repeater::configureUsing(
            fn (Repeater $repeater) => $repeater
                ->collapsible()
                ->cloneable()
                ->defaultItems(1)
                ->columnSpanFull()
        );
    }
}
