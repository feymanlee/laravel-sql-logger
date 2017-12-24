<?php

namespace Feyman\LaravelSqlLogger\Providers;

use Feyman\LaravelSqlLogger\SqlLogger;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->setConfig();

        // if any of logging type is enabled we will listen database to get all
        // executed queries
        if ($this->app['config']->get('sql_logger.log_queries') ||
            $this->app['config']->get('sql_logger.log_slow_queries')) {
            // create logger class
            $logger = new SqlLogger($this->app);

            // listen to database queries
            $this->app['db']->listen(function (
                $query,
                $bindings = null,
                $time = null
            ) use ($logger) {
                $logger->log($query, $bindings, $time);
            });
        }
    }

    protected function setConfig()
    {
        $source = realpath(__DIR__ . '/../../config/sql_logger.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => (function_exists('config_path') ?
                    config_path('sql_logger.php') :
                    base_path('config/sql_logger.php')),
            ]);
        }
        $this->mergeConfigFrom($source, 'sql_logger');
    }
}