<?php

declare(strict_types = 1);

namespace MrVaco\Status\Layouts;

use MrVaco\Status\Models\Group as StatusGroup;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;

class StatusCURows extends Rows
{
    protected function fields(): array
    {
        return [
            Group::make([
                Input::make('status.name')
                    ->type('text')
                    ->title(__('Name'))
                    ->placeholder(__('Name'))
                    ->max(255)
                    ->required()
                    ->horizontal(),

                Switcher::make('status.active')
                    ->title('Active by default')
                    ->sendTrueOrFalse()
                    ->horizontal(),
            ]),

            Group::make([
                Input::make('status.color')
                    ->type('color')
                    ->title(__('Color'))
                    ->value('#' . substr(md5((string) rand()), 0, 6))
                    ->horizontal(),

                Switcher::make('status.disabled')
                    ->title('Disabled by default')
                    ->sendTrueOrFalse()
                    ->horizontal(),
            ]),

            Group::make([
                Select::make('status.group')
                    ->title(__('Groups'))
                    ->fromQuery(StatusGroup::query(), 'name')
                    ->multiple()
                    ->horizontal(),

                Switcher::make('status.draft')
                    ->title('Draft by default')
                    ->sendTrueOrFalse()
                    ->horizontal(),
            ]),
        ];
    }
}
