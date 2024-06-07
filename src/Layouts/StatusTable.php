<?php

declare(strict_types = 1);

namespace MrVaco\Status\Layouts;

use MrVaco\Status\Classes\StatusContent;
use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Models\Status;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\Boolean;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StatusTable extends Table
{
    public $target = 'statuses';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->cantHide()
                ->render(fn (Status $status) => new StatusContent($status)),

            TD::make('color', __('Color'))
                ->alignCenter()
                ->defaultHidden(),

            TD::make('group', __('Groups'))
                ->alignCenter()
                ->width('200px')
                ->render(fn (Status $status) => $status->group->map(function ($group) {
                    return $group->name;
                })->implode('<br />')),

            TD::make('active', __('Active by default'))
                ->usingComponent(Boolean::class)
                ->width('150px')
                ->alignCenter(),

            TD::make('disabled', __('Disabled by default'))
                ->usingComponent(Boolean::class)
                ->width('150px')
                ->alignCenter(),

            TD::make('draft', __('Draft by default'))
                ->usingComponent(Boolean::class)
                ->width('150px')
                ->alignCenter(),

            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->alignCenter()
                ->defaultHidden(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->alignCenter(),

            TD::make(__('Actions'))
                ->alignCenter()
                ->width('100px')
                ->canSee(auth()->user()->hasAnyAccess([StatusEnum::UPDATE, StatusEnum::DELETE]))
                ->render(fn (Status $status) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->icon('bs.pencil')
                            ->canSee(auth()->user()->hasAccess(StatusEnum::UPDATE))
                            ->route(StatusEnum::UPDATE, $status->id),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->canSee(auth()->user()->hasAccess(StatusEnum::DELETE))
                            ->confirm(__('Confirm status deletion'))
                            ->method('remove', ['id' => $status->id]),
                    ])),
        ];
    }
}
