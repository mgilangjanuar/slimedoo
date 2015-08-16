<?php

// auto public route for all controller classes
foreach (App::autoload(App::path('app/controllers'), '.php') as $controller) {
    $class = '\\' . str_replace('/', '\\', str_replace('.php', '', $controller));
    foreach ((new $class)->routes() as $to => $source) {
        App::$app->map($to, $source)->via('GET', 'POST');
    }
}