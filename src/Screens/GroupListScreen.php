<?php

declare(strict_types = 1);

namespace MrVaco\Status\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Layouts\GroupTable;
use MrVaco\Status\Layouts\Tabs;
use MrVaco\Status\Models\Group;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class GroupListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'groups' => Group::query()
                ->paginate()
        ];
    }

    public function name(): ?string
    {
        return __('Groups');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus')
                ->canSee(auth()->user()->hasAccess(StatusEnum::GROUP_CREATE))
                ->route(StatusEnum::GROUP_CREATE),
        ];
    }

    public function layout(): iterable
    {
        return [
            Tabs::class,
            GroupTable::class,
        ];
    }

    public function remove(Request $request): RedirectResponse
    {
        $status = Group::query()->findOrFail($request->get('id'));
        $status->statuses()->detach();
        $status->delete();

        Toast::info(__('Group deleted'));

        return redirect()->route(StatusEnum::GROUP_VIEW);
    }

    public function permission(): ?iterable
    {
        return [StatusEnum::GROUP_VIEW];
    }
}
