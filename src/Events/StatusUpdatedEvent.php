<?php

namespace MrVaco\Status\Events;

use Illuminate\Foundation\Events\Dispatchable;
use MrVaco\Status\Models\Status;

class StatusUpdatedEvent
{
    use Dispatchable;

    public Status $status;

    public function __construct(Status $status)
    {
        $this->status = $status;
    }
}
