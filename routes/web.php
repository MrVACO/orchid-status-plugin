<?php

declare(strict_types = 1);

use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Screens\GroupCreateScreen;
use MrVaco\Status\Screens\GroupListScreen;
use MrVaco\Status\Screens\GroupUpdateScreen;
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

        app('router')
            ->name('')
            ->prefix('group')
            ->group(static function () {
                app('router')
                    ->screen('', GroupListScreen::class)
                    ->name(StatusEnum::GROUP_VIEW);

                app('router')
                    ->screen('create', GroupCreateScreen::class)
                    ->name(StatusEnum::GROUP_CREATE);

                app('router')
                    ->screen('{group}/update', GroupUpdateScreen::class)
                    ->name(StatusEnum::GROUP_UPDATE);
            });
    });
