<?php

namespace Simple;

class DepsInjection
{
    public static function run()
    {
        Storage::set('settings', require '../config/app.php');
        Storage::set('app', new App);
        Storage::set('router', new Router);
        Storage::set('view', new View);
    }
}
