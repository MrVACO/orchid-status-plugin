<?php

use Illuminate\Database\Migrations\Migration;
use MrVaco\Status\Models\Group;
use MrVaco\Status\Models\Status;

return new class extends Migration
{
    protected array $statuses = [
        [
            'name' => 'New',
            'color' => '#008ae6',
            'active' => false,
            'disabled' => false,
            'draft' => false,
        ],
        [
            'name' => 'Draft',
            'color' => '#8f8f8f',
            'active' => false,
            'disabled' => false,
            'draft' => true,
        ],
        [
            'name' => 'Disabled',
            'color' => '#A94442',
            'active' => false,
            'disabled' => true,
            'draft' => false,
        ],
        [
            'name' => 'Actively',
            'color' => '#31c433',
            'active' => true,
            'disabled' => false,
            'draft' => false,
        ],
    ];

    protected array $group = [
        [
            'name' => 'Full',
            'slug' => 'full',
            'statuses' => [1, 2, 3, 4]
        ],
        [
            'name' => 'Base',
            'slug' => 'base',
            'statuses' => [1, 2, 3, 4]
        ],
        [
            'name' => 'Short',
            'slug' => 'short',
            'statuses' => [2, 3, 4]
        ],
    ];

    public function up(): void
    {
        foreach ($this->statuses as $status)
            $this->createStatus($status);


        foreach ($this->group as $list)
        {
            $ids = $list['statuses'];
            unset($list['statuses']);

            $value = $this->createGroups($list);
            $value->statuses()->sync($ids);
        }
    }

    protected function createStatus(array $data): void
    {
        Status::query()->create($data);
    }

    protected function createGroups(array $data): Group
    {
        return Group::query()->create($data);
    }
};
