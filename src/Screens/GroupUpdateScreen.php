<?php

declare(strict_types = 1);

namespace MrVaco\Status\Screens;

use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Traits\GroupCUTrait;
use Orchid\Screen\Screen;

class GroupUpdateScreen extends Screen
{
    use GroupCUTrait;

    public function permission(): ?iterable
    {
        return [
            StatusEnum::GROUP_CREATE
        ];
    }
}
