<h1 align="center"> Laravel Sql Logger </h1>

<p align="center">:pencil: This package allows you to log SQL queries (and slow SQL queries) to log file in Laravel/Lumen framework.
Inspiration form <a href="https://github.com/mnabialek/laravel-sql-logger">mnabialek/laravel-sql-logger</a></p>

## Installation

```php   
composer require feyman/laravel-sql-logger --dev
```
   
Please keep the `--dev` option. (it's recommended to use this package only for development). 
The Logger will be enabled when `APP_DEBUG` is true

## Configuration

If you use Laravel < 5.5 open `app/Providers/AppServiceProvider.php` and in `register` method add:

```php
public function register()
{
    if ($this->app['config']->get('app.debug')) {
        $this->app->register(\Feyman\LaravelSqlLogger\Providers\ServiceProvider::class);
    }
}
```
    
> Laravel 5.5 uses Package Auto-Discovery and it will automatically load this service provider so you don't need to add anything into above file.
    
If you are using Lumen open `bootstrap/app.php` and add:
    
```php
if (env('APP_DEBUG')) {
    $app->register(\Feyman\LaravelSqlLogger\Providers\LumenServiceProvider::class);
}
```
    
If you use Laravel < 5.5 run:
    
```php
php artisan vendor:publish --provider="Feyman\LaravelSqlLogger\Providers\ServiceProvider"
```
    
in your console to publish default configuration files.
    
#### If you are using Laravel 5.5 run:
    
```php
php artisan vendor:publish
```
    
and choose the number matching `"Feyman\LaravelSqlLogger\Providers\ServiceProvider"` provider.
This operation will create config file in `config/sql_loger.php`.
By default you should not edit published file because all the settings are loaded from `.env` file by default.

For Lumen you should skip this step. 
        
#### In your .env file add the following entries:

```
# Whether all SQL queries should be logged
SQL_LOG_QUERIES=true 

# Whether slow SQL queries should be logged (you can log all queries and
# also slow queries in separate file or you might to want log only slow queries)
SQL_LOG_SLOW_QUERIES=true

# Time of query (in milliseconds) when this query is considered as slow
SQL_SLOW_QUERIES_MIN_EXEC_TIME=100

#Whether slow SQL queries should be logged (you can log all queries and
#also slow queries in separate file or you might to want log only slow queries)
SQL_LOG_OVERRIDE=false

# Directory where log files will be saved
SQL_LOG_DIRECTORY=logs/sql

# Whether execution time in log file should be displayed in seconds(by default it's in milliseconds)
SQL_CONVERT_TIME_TO_SECONDS=false

# Whether artisan queries should be logged to separate files
SQL_LOG_SEPARATE_ARTISAN=false
```
    
## License
MIT