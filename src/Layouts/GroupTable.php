<?php

declare(strict_types = 1);

namespace MrVaco\Status\Layouts;

use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Models\Group;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GroupTable extends Table
{
    public $target = 'groups';

    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->cantHide()
                ->render(fn (Group $group) => auth()->user()->hasAccess(StatusEnum::GROUP_UPDATE)
                    ? Link::make($group->name)->route(StatusEnum::GROUP_UPDATE, $group->id)
                    : Link::make($group->name)
                ),

            TD::make('slug', __('Slug'))
                ->alignCenter(),

            TD::make('statuses_count', __('Statuses count'))
                ->alignCenter()
                ->render(fn (Group $group) => $group->statuses->count()),

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
                ->canSee(auth()->user()->hasAnyAccess([StatusEnum::GROUP_UPDATE, StatusEnum::GROUP_DELETE]))
                ->render(fn (Group $group) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->icon('bs.pencil')
                            ->canSee(auth()->user()->hasAccess(StatusEnum::GROUP_UPDATE))
                            ->route(StatusEnum::GROUP_UPDATE, $group->id),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->canSee(auth()->user()->hasAccess(StatusEnum::GROUP_DELETE))
                            ->confirm(__('Confirm status deletion'))
                            ->method('remove', ['id' => $group->id]),
                    ])),
        ];
    }
}
