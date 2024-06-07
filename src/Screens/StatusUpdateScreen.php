<?php

declare(strict_types = 1);

namespace MrVaco\Status\Screens;

use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Traits\StatusCUTrait;
use Orchid\Screen\Screen;

class StatusUpdateScreen extends Screen
{
    use StatusCUTrait;

    public function permission(): ?iterable
    {
        return [
            StatusEnum::UPDATE
        ];
    }
}
