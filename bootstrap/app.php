<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

// isolate artisan console log and laravel service log
// See: https://stackoverflow.com/questions/27674597/laravel-daily-log-created-with-wrong-permissions
$app->configureMonologUsing(function(Monolog\Logger $monolog) {
    // default file name
    $filename = storage_path('logs/laravel.log');
    $sapi = php_sapi_name();
    // if running on the command line(php artisan only, except cliserver mode), to  change log file name.
    if ($sapi == 'cli') {
        $filename = storage_path('logs/laravel-cli.log');
    }
    // The maximal amount of files to keep (0 means unlimited)
    $maxFiles = config('app.log_max_files', 0);
    $levelString = config('app.log_level', 'debug');
    $levels = [
        'debug'     => \Monolog\Logger::DEBUG,
        'info'      => \Monolog\Logger::INFO,
        'notice'    => \Monolog\Logger::NOTICE,
        'warning'   => \Monolog\Logger::WARNING,
        'error'     => \Monolog\Logger::ERROR,
        'critical'  => \Monolog\Logger::CRITICAL,
        'alert'     => \Monolog\Logger::ALERT,
        'emergency' => \Monolog\Logger::EMERGENCY,
    ];
    $level = \Monolog\Logger::INFO;
    if (isset($levels[$levelString])) {
        $level = $levels[$levelString];
    }

    // default file permission.
    $permission = 0644;
    $handler = new Monolog\Handler\RotatingFileHandler($filename, $maxFiles, $level, true, $permission);
    $monolog->pushHandler($handler);
});
//-------------------- END HERE

return $app;
