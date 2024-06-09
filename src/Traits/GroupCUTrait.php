<?php

declare(strict_types = 1);

namespace MrVaco\Status\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Layouts\GroupCURows;
use MrVaco\Status\Models\Group;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

trait GroupCUTrait
{
    public $group;

    public function query(Group $group): iterable
    {
        return [
            'group' => $group,
        ];
    }

    public function name(): ?string
    {
        return $this->group->exists
            ? __('Update :name', ['name' => $this->group->name])
            : __('Create group');
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save & close'))
                ->type(Color::SUCCESS)
                ->icon('bs.check-circle-fill')
                ->canSee(auth()->user()->hasAccess(StatusEnum::GROUP_CREATE))
                ->method('saveAndClose'),

            Button::make(__('Save'))
                ->type(Color::PRIMARY)
                ->icon('bs.check-circle')
                ->canSee($this->group->exists && auth()->user()->hasAccess(StatusEnum::GROUP_UPDATE))
                ->method('save'),

            Link::make(__('Cancel'))
                ->icon('bs.x')
                ->route(StatusEnum::GROUP_VIEW),

            Button::make(__('Remove'))
                ->type(Color::DANGER)
                ->icon('bs.trash3-fill')
                ->canSee($this->group->exists && auth()->user()->hasAccess(StatusEnum::GROUP_DELETE))
                ->confirm(__('The group will be deleted without the possibility of recovery'))
                ->method('remove'),
        ];
    }

    public function layout(): iterable
    {
        return [
            GroupCURows::class,
        ];
    }

    public function save(Group $group, Request $request): void
    {
        $request->validate([
            'group.name' => [
                'required'
            ],
            'group.slug' => [
                'required'
            ],
        ]);

        $group->fill($request->collect('group')->toArray())->save();

        $statuses = $request->input('group.statuses');
        $group->statuses()->detach();
        $group->statuses()->attach($statuses);

        Toast::success(__('Saved'));
    }

    public function saveAndClose(Group $group, Request $request): RedirectResponse
    {
        $this->save($group, $request);

        return redirect()->route(StatusEnum::GROUP_VIEW);
    }

    public function remove(Group $group): RedirectResponse
    {
        $group->statuses()->detach();
        $group->delete();

        Toast::info(__('Deleted'));

        return redirect()->route(StatusEnum::GROUP_VIEW);
    }
}
