<?php

declare(strict_types = 1);

namespace MrVaco\Status\Classes;

enum StatusEnum
{
    const author = 'mr_vaco';
    const prefix = self::author . '.statuses';

    const VIEW = self::prefix . '.status.view';
    const CREATE = self::prefix . '.status.create';
    const UPDATE = self::prefix . '.status.update';
    const DELETE = self::prefix . '.status.delete';

    const GROUP_VIEW = self::prefix . '.group.view';
    const GROUP_CREATE = self::prefix . '.group.create';
    const GROUP_UPDATE = self::prefix . '.group.update';
    const GROUP_DELETE = self::prefix . '.group.delete';
}
