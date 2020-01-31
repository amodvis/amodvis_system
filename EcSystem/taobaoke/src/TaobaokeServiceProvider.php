<?php

namespace ES\Taobaoke;

use Exception;

use Illuminate\Support\ServiceProvider;
use ES\Taobaoke\Libraries\Library;

use ES\Taobaoke\Log\LogIntf;
use ES\Taobaoke\Log\MedLogger;
use ES\Taobaoke\SDK\top\TopLogger;

class TaobaokeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/config.php' => config_path('taobaoke.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('taobaoke', function() {
            return new Library();
        });

        $this->app->bind('ES\Taobaoke\Contracts\Contract', 'ES\Taobaoke\Libraries\Library');

        $logConcrete = config('taobaoke.topLoggerDefault') ? TopLogger::class : MedLogger::class;

        $this->app->bind(LogIntf::class, $logConcrete);
    }
}
