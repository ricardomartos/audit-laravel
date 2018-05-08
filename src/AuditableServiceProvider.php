<?php

namespace Ricardo\Auditable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('auditable', function() {
            $this->string('created_by')->nullable()->index();
            $this->string('updated_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function() {
            $this->dropColumn(['created_by', 'updated_by']);
        });
    }
}
