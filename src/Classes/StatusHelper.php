<?php

declare(strict_types = 1);

namespace MrVaco\Status\Classes;

use MrVaco\Status\Models\Group;
use MrVaco\Status\Models\Status;

class StatusHelper
{
    static function ACTIVE($groupSlug): ?Status
    {
        return self::getGroupBySlug($groupSlug)->statuses->firstWhere('active', true);
    }

    static function DISABLED($groupSlug): ?Status
    {
        return self::getGroupBySlug($groupSlug)->statuses->firstWhere('disabled', true);
    }

    static function DRAFT($groupSlug): ?Status
    {
        return self::getGroupBySlug($groupSlug)->statuses->firstWhere('draft', true);
    }

    static function LIST(string $slug, bool $swap = false): array
    {
        $data = Status::query()->whereHas('group', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->get();

        return $swap
            ? $data->pluck('id', 'name')->toArray()
            : $data->pluck('name', 'id')->toArray();
    }

    static function getGroupBySlug(string $slug): ?Group
    {
        return Group::query()->where('slug', $slug)->firstOrFail();
    }

    static function BY_ID(int $id): Status
    {
        return Status::query()->where('id', $id)->firstOrFail();
    }
}
