<?php

declare(strict_types = 1);

namespace MrVaco\Status\Layouts;

use MrVaco\Status\Models\Status;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class GroupCURows extends Rows
{
    protected function fields(): iterable
    {
        return [
            Input::make('group.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name'))
                ->horizontal(),

            Input::make('group.slug')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Slug'))
                ->placeholder(__('Slug'))
                ->horizontal(),

            Select::make('group.statuses')
                ->title(__('Statuses'))
                ->fromQuery(Status::query(), 'name')
                ->multiple()
                ->horizontal(),
        ];
    }
}
