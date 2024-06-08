<?php

declare(strict_types = 1);

namespace MrVaco\Status;

use Illuminate\Support\Facades\View;
use MrVaco\Status\Classes\StatusEnum;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class ServiceProvider extends OrchidServiceProvider
{
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        $this->publish();
        $this->router();

        View::addNamespace(StatusEnum::prefix, __DIR__ . '/../resources/views');
    }

    public function menu(): array
    {
        return [
            Menu::make(__('Status management'))
                ->icon('bs.check2-square')
                ->permission(StatusEnum::VIEW)
                ->route(StatusEnum::VIEW)
                ->active(StatusEnum::prefix . '*')
                ->sort(100),
        ];
    }

    protected function publish(): void
    {
        if (!$this->app->runningInConsole())
            return;

        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'plugin-migrations');
    }

    public function router(): void
    {
        app('router')
            ->domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->group(__DIR__ . '/../routes/web.php');
    }

    public function permissions(): array
    {
        return [
            ItemPermission::group(__('Status management'))
                ->addPermission(StatusEnum::VIEW, __('View statuses'))
                ->addPermission(StatusEnum::CREATE, __('Create status'))
                ->addPermission(StatusEnum::UPDATE, __('Update status'))
                ->addPermission(StatusEnum::DELETE, __('Delete status'))
                ->addPermission(StatusEnum::GROUP_VIEW, __('View groups'))
                ->addPermission(StatusEnum::GROUP_CREATE, __('Create group'))
                ->addPermission(StatusEnum::GROUP_UPDATE, __('Update group'))
                ->addPermission(StatusEnum::GROUP_DELETE, __('Delete group')),
        ];
    }
}
