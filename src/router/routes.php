<?php

namespace Routes;

use App\Common\App;
use App\Controller\Login\LoginHandler;
use App\Controller\Login\LogoutHandler;
use App\Controller\Tasks\AddHandler;
use App\Controller\Tasks\EditHandler;
use App\Controller\Tasks\IndexHandler;
use League\Route\Router;


function init(Router $router, App $app)
{
    $router->get('/', new IndexHandler($app->getRenderer(), $app->getPDO()));
    $router->get('/add', new AddHandler($app->getRenderer(), $app->getPDO(), $app));
    $router->post('/add', new AddHandler($app->getRenderer(), $app->getPDO(), $app));

    $router->get('/edit/{id}', new EditHandler($app->getRenderer(), $app->getPDO(), $app));
    $router->post('/edit/{id}', new EditHandler($app->getRenderer(), $app->getPDO(), $app));

    $router->get('/login', new LoginHandler($app->getRenderer(), $app->getPDO(), $app));
    $router->post('/login', new LoginHandler($app->getRenderer(), $app->getPDO(), $app));
    $router->post('/logout', new LogoutHandler($app->getRenderer(), $app->getPDO(), $app));
}