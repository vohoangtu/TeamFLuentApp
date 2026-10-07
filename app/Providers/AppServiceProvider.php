<?php

namespace App\Providers;

use App\Events\MemberAssignedToProject;
use App\Events\MemberUnassignedFromProject;
use App\Events\MemberWorkloadExceeded;
use App\Listeners\LogProjectAssignmentActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enterprise strict mode: catches N+1 queries, unfillable attributes, and missing attributes early
        Model::shouldBeStrict(! $this->app->isProduction());

        // Enterprise Event & Audit logging wiring
        Event::listen(MemberAssignedToProject::class, [LogProjectAssignmentActivity::class, 'handleAssignment']);
        Event::listen(MemberUnassignedFromProject::class, [LogProjectAssignmentActivity::class, 'handleUnassignment']);
        Event::listen(MemberWorkloadExceeded::class, [LogProjectAssignmentActivity::class, 'handleOverallocation']);
    }
}
