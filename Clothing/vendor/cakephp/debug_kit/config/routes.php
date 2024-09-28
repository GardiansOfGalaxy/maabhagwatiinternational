<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin('DebugKit', ['path' => '/debug-kit'], function (RouteBuilder $routes) {
    $routes->setExtensions('json');
    $routes->setRouteClass(DashedRoute::class);

    $routes->connect(
        '/toolbar/clear-cache',
        ['controller' => 'Toolbar', 'action' => 'clearCache']
    );
    $routes->connect(
        '/toolbar/*',
        ['controller' => 'Requests', 'action' => 'home']
    );
    $routes->connect(
        '/panels/home/latest-history',
        ['controller' => 'Panels', 'action' => 'latestHistory']
    );
    $routes->connect(
        '/panels/home/*',
        ['controller' => 'Panels', 'action' => 'home']
    );
    $routes->connect(
        '/panels/*',
        ['controller' => 'Panels', 'action' => 'index']
    );

    $routes->connect(
        '/composer/check-dependencies',
        ['controller' => 'Composer', 'action' => 'checkDependencies']
    );

    $routes->scope(
        '/mail-prehome',
        ['controller' => 'MailPrehome'],
        function (RouteBuilder $routes) {
            $routes->connect('/', ['action' => 'index']);
            $routes->connect('/prehome', ['action' => 'email']);
            $routes->connect('/prehome/*', ['action' => 'email']);
            $routes->connect('/sent/{panel}/{id}', ['action' => 'sent'], ['pass' => ['panel', 'id']]);
        }
    );

    $routes->get('/', ['controller' => 'Dashboard', 'action' => 'index']);
    $routes->get('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
    $routes->post('/dashboard/reset', ['controller' => 'Dashboard', 'action' => 'reset']);
});
