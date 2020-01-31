<?php
/**
 * Created by PhpStorm.
 * User: Louv
 * Date: 2019/6/14
 * Time: 11:39
 */

namespace ES\MQ\Providers;

use Illuminate\Support\ServiceProvider AS LaravelServiceProvider;

class MQServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('es-mq.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}