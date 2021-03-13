<?php

declare(strict_types=1);

namespace App\Router;

use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use Nette\StaticClass;


final class RouterFactory
{
    use StaticClass;

    /**
     * @return RouteList<Router>
     */
    public static function createRouter(): RouteList
    {
        $router = new RouteList();

        $router
            ->withModule('Admin')
                ->addRoute(
                    'sign/<action>',
                    [
                        "presenter" => "Sign",
                        "action" => "in",
                    ]
                )
            ->end()

            ->withModule('Front')
                ->addRoute(
                    '<presenter>/<action>',
                    [
                        "presenter" => "Homepage",
                        "action" => "default",
                    ]
                )
            ->end();

        return $router;
    }
}
