<?php

namespace MrVaco\Status\Listeners;

use MrVaco\Status\Events\StatusUpdatedEvent;
use MrVaco\Status\Models\Group;
use MrVaco\Status\Models\Status;

class StatusUpdatedListener
{
    public function __construct() {}

    public function handle(StatusUpdatedEvent $event): void
    {
        $this->refreshStatuses($event->status);
    }

    private function refreshStatuses(Status $model): void
    {
        $this->update($model, [
            'active' => $model->active,
            'disabled' => $model->disabled,
            'draft' => $model->draft,
        ]);
    }

    private function update(Status $status, array $statuses): void
    {
        $columns = collect($statuses)->filter();

        $status->group->map(function (Group $group) use ($status, $columns) {
            $group->statuses->each(function (Status $model) use ($status, $columns) {
                $model::query()
                    ->whereNot('id', $status->id)
                    ->where('id', $model->id)
                    ->update(
                        $columns->map(fn (bool $value) => false)->all()
                    );
            });
        });
    }
}
