<?php

namespace Simple;

class App
{
    public function run()
    {
        $router = Storage::get('router');
        $settings = Storage::get('settings');

        $compiledRoutes = $settings['compiledRoutes'];
        $request = filter_input(INPUT_GET, 'r');
        $routeInfo = $router->dispatch($request, $compiledRoutes);
        if ($routeInfo[0] === Router::NOT_FOUND) {
            $view = Storage::get('view');
            return $view->render($settings['notFountTemplate']);
        }

        $controllerName = $routeInfo[1][0];
        $actionName = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $className = "Controllers\\{$controllerName}";
        $controller = new $className;
        return $controller->$actionName($vars);
    }
}
