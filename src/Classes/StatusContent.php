<?php

declare(strict_types = 1);

namespace MrVaco\Status\Classes;

use Illuminate\View\View;
use MrVaco\Status\Models\Status;
use Orchid\Screen\Layouts\Content;

class StatusContent extends Content
{
    public function render(Status $status): View
    {
        $canUpdate = auth()->user()->hasAccess(StatusEnum::UPDATE);

        if (!$canUpdate)
            return view(StatusEnum::prefix . '::status_preview', ['status' => $status]);

        return view(StatusEnum::prefix . '::status_table_td', [
            'url' => route(StatusEnum::UPDATE, $status->id),
            'status' => $status,
            'view' => StatusEnum::prefix . '::status_preview'
        ]);
    }
}
