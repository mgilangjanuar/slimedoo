<?php

session_start();

require 'vendor/autoload.php';
require 'app/system/App.php';

use \App;

App::init(
    new \Slim\Slim,
    new \ptejada\uFlex\User,
    new \PHPMailer
);

date_default_timezone_set(App::config()->timezone);

foreach (App::autoload(App::path('app/system/base'), '.php') as $systemClass) {
    require $systemClass;
}

foreach (App::autoload(App::path('app/component'), '.php') as $appComponent) {
    require $appComponent;
}

foreach (App::autoload(App::path('app/models'), '.php') as $appModel) {
    require $appModel;
}

foreach (App::autoload(App::path('app/controllers'), '.php') as $appController) {
    require $appController;
}

// auto public route for all controller classes
foreach (App::autoload(App::path('app/controllers'), '.php') as $controller) {
    $class = '\\' . str_replace('/', '\\', str_replace('.php', '', $controller));
    foreach ((new $class)->routes() as $to => $source) {
        App::$app->map($to, $source)->via('GET', 'POST')->name($source . ':' . $to);
    }
}