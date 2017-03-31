<?php
require_once '../vendor/autoload.php';

use Klein\Klein;
use Minifier\Manager\ServiceManager;

$klein = new Klein();

ServiceManager::initService($klein);

$klein->respond('GET', '/u/[s:token]', array('Minifier\Controller\RedirectController', 'redirectAction'));

$klein->with('/user', function (Klein $klein) {
    $klein->respond(array('GET', 'POST'), '/login', array('Minifier\Controller\UserController', 'loginAction'));
});

$klein->with('/api', function(Klein $klein) {
    $klein->with('/route', function(Klein $klein) {
        $klein->respond('GET', '', array('Minifier\Controller\Api\RouteApiController', 'getAction'));
        $klein->respond('POST', '', array('Minifier\Controller\Api\RouteApiController', 'postAction'));
        $klein->respond('PUT', '', array('Minifier\Controller\Api\RouteApiController', 'putAction'));
        $klein->respond('DELETE', '', array('Minifier\Controller\Api\RouteApiController', 'deleteAction'));
    });
});

$klein->dispatch();

