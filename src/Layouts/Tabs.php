<?php

declare(strict_types = 1);

namespace MrVaco\Status\Layouts;

use MrVaco\Status\Classes\StatusEnum;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\TabMenu;

class Tabs extends TabMenu
{
    protected function navigations(): iterable
    {
        return [
            Menu::make(__('Statuses'))->route(StatusEnum::VIEW),
            Menu::make(__('Groups'))->route(StatusEnum::GROUP_VIEW),
        ];
    }
}
