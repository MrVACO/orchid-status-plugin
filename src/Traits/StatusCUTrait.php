<?php

declare(strict_types = 1);

namespace MrVaco\Status\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MrVaco\Status\Classes\StatusEnum;
use MrVaco\Status\Events\StatusUpdatedEvent;
use MrVaco\Status\Layouts\StatusCURows;
use MrVaco\Status\Models\Status;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

trait StatusCUTrait
{
    public $status;

    public function query(Status $status): iterable
    {
        return [
            'status' => $status,
        ];
    }

    public function name(): ?string
    {
        return $this->status->exists
            ? __('Update status')
            : __('Create status');
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save & close'))
                ->type(Color::SUCCESS)
                ->icon('bs.check-circle-fill')
                ->canSee(auth()->user()->hasAccess(StatusEnum::CREATE))
                ->method('saveAndClose'),

            Button::make(__('Save'))
                ->type(Color::PRIMARY)
                ->icon('bs.check-circle')
                ->canSee($this->status->exists && auth()->user()->hasAccess(StatusEnum::UPDATE))
                ->method('save'),

            Link::make(__('Cancel'))
                ->icon('bs.x')
                ->route(StatusEnum::VIEW),

            Button::make(__('Remove'))
                ->type(Color::DANGER)
                ->icon('bs.trash3-fill')
                ->canSee($this->status->exists && auth()->user()->hasAccess(StatusEnum::DELETE))
                ->confirm(__('The status will be deleted without the possibility of recovery'))
                ->method('remove'),
        ];
    }

    public function layout(): iterable
    {
        return [
            StatusCURows::class
        ];
    }

    public function save(Status $status, Request $request): void
    {
        $request->validate([
            'status.name' => [
                'required',
            ],
        ]);

        $status->fill($request->collect('status')->toArray())->save();

        $groups = $request->input('status.group');
        $status->group()->detach();
        $status->group()->attach($groups);

        StatusUpdatedEvent::dispatch($status);

        Toast::success(__('Saved'));
    }

    public function saveAndClose(Status $status, Request $request): RedirectResponse
    {
        $this->save($status, $request);

        return redirect()->route(StatusEnum::VIEW);
    }

    public function remove(Status $status): RedirectResponse
    {
        $status->group()->detach();
        $status->delete();

        Toast::info(__('Deleted'));

        return redirect()->route(StatusEnum::VIEW);
    }
}
