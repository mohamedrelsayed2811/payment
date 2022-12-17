<?php

namespace Radwan\Payment;

use Illuminate\Support\ServiceProvider;


class PaymentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configure();
        $this->registerPublishing();
        
        $this->publishes([
            __DIR__ . '/../config/radwan-payments.php' => config_path('radwan-payments.php'),
        ]);

    }



    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/radwan-payments.php', 'radwan-payments'
        );
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/radwan-payments.php' => config_path('radwan-payments.php'),
        ], 'radwan-payments-config');
       

    }
    
}
