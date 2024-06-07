<?php

declare(strict_types = 1);

use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Screens\StatusCreateScreen;
use MrVaco\Status\Screens\StatusListScreen;
use MrVaco\Status\Screens\StatusUpdateScreen;

app('router')
    ->middleware(config('platform.middleware.private'))
    ->prefix('status')
    ->group(static function () {
        app('router')
            ->name('')
            ->group(static function () {
                app('router')
                    ->screen('', StatusListScreen::class)
                    ->name(StatusEnum::VIEW);

                app('router')
                    ->screen('create', StatusCreateScreen::class)
                    ->name(StatusEnum::CREATE);

                app('router')
                    ->screen('{status}/update', StatusUpdateScreen::class)
                    ->name(StatusEnum::UPDATE);
            });
    });
