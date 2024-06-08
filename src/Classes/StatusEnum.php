<?php

declare(strict_types = 1);

namespace MrVaco\Status\Classes;

enum StatusEnum
{
    const author = 'mr_vaco';
    const prefix = self::author . '.statuses';
    const prefixStatus = self::prefix . '.status';
    const prefixGroup = self::prefix . '.group';

    const VIEW = self::prefixStatus . '.view';
    const CREATE = self::prefixStatus . '.create';
    const UPDATE = self::prefixStatus . '.update';
    const DELETE = self::prefixStatus . '.delete';

    const GROUP_VIEW = self::prefixGroup . '.view';
    const GROUP_CREATE = self::prefixGroup . '.create';
    const GROUP_UPDATE = self::prefixGroup . '.update';
    const GROUP_DELETE = self::prefixGroup . '.delete';
}
