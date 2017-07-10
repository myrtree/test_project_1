<?php

namespace Simple;

class Router
{
    const DEFAULT_PATTERN = '[^/]+';
    const FOUND = 'FOUND';
    const NOT_FOUND = 'NOT_FOUND';
    protected $routesData = null;

    private function compile(array $routes): array
    {
        $groupsCount = 0;

        foreach ($routes as $routePattern => $handler) {
            $varNames = [];

            if (preg_match_all('~\{(?<vars>[^/]+)\}~', $routePattern, $routeVars)) {
                foreach ($routeVars['vars'] as $routeVar) {
                    $varNameAndPattern = explode(':', $routeVar, 2);

                    $varNames[] = $varNameAndPattern[0];
                    $varPattern = count($varNameAndPattern) > 1
                        ? $varNameAndPattern[1]
                        : self::DEFAULT_PATTERN;

                    $routePattern = str_replace("{{$routeVar}}", "({$varPattern})", $routePattern);
                }
            }

            $varsCount = count($routeVars['vars']);
            $groupsCount = max($groupsCount, $varsCount);

            $this->routesData[$groupsCount + 1] = [
                'pattern' => $routePattern,
                'handler' => $handler,
                'varsCount' => $varsCount,
                'varNames' => $varNames,
            ];

            $regexes[] = $routePattern . str_repeat('()', $groupsCount - $varsCount);
            $groupsCount++;
        }

        $this->routesData['regex'] = '~^(?|'. implode('|', $regexes) .')$~x';

        return $this->routesData;
    }

    private function save()
    {
        $settings = Storage::get('settings');
        $fileName = $settings['compiledRoutes'];

        $output = fopen($fileName, 'w');
        fwrite(
            $output,
            "<?php\n\nreturn ". var_export($this->routesData, true) .";\n"
        );
        fclose($output);
    }

    public function dispatch($url, $fileName = 'compiled.php'): array
    {
        $settings = Storage::get('settings');
        $fileName = $settings['compiledRoutes'];

        if (!file_exists($fileName)) {
            $routes = require $settings['routes'];
            $this->compile($routes);
            $this->save($settings['compiledRoutes']);
        }

        $routes = require $fileName;

        if (preg_match($routes['regex'], $url, $matches)) {
            $route = $routes[count($matches)];

            $vars = [];
            $varValues = array_slice($matches, 1, $route['varsCount']);
            foreach ($route['varNames'] as $varName) {
                $vars[$varName] = array_shift($varValues);
            }

            return [self::FOUND, $route['handler'], $vars];
        }

        return [self::NOT_FOUND];
    }
}
