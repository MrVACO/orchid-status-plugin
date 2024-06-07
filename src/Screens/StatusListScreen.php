<?php

declare(strict_types = 1);

namespace MrVaco\Status\Screens;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Layouts\StatusTable;
use MrVaco\Status\Layouts\Tabs;
use MrVaco\Status\Models\Status;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class StatusListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'statuses' => Status::query()
                ->paginate()
        ];
    }

    public function name(): ?string
    {
        return __('Status management');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus')
                ->canSee(auth()->user()->hasAccess(StatusEnum::CREATE))
                ->route(StatusEnum::CREATE),
        ];
    }

    public function layout(): iterable
    {
        return [
            Tabs::class,
            StatusTable::class,
        ];
    }

    public function remove(Request $request): RedirectResponse
    {
        $status = Status::query()->findOrFail($request->get('id'));
        $status->group()->detach();
        $status->delete();

        Toast::info(__('Status deleted'));

        return redirect()->route(StatusEnum::VIEW);
    }

    public function permission(): ?iterable
    {
        return [StatusEnum::VIEW];
    }
}
