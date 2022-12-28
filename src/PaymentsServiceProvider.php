<?php

namespace Radwan\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentsServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        
        $this->publishes([
            __DIR__.'/../config/radwan-payments.php' => config_path('radwan-payments.php')
        ], 'radwan-payments');

        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations'),
        ], 'migrations');

    }



    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/radwan-payments.php', 'radwan-payments'
        );
    }


}
