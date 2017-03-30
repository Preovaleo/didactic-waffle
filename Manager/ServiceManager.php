<?php

namespace Minifier\Manager;

use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;
use Minifier\Config\Config;
use Minifier\Repository\UserRepository;

class ServiceManager
{

    public static function initService(Klein $klein)
    {
        $klein->respond(function (Request $request, Response $reponse, ServiceProvider $service, App $app) {
            $app->register('pdo', function () {
                return new \PDO(sprintf('mysql:host=%s;dbname=%s', Config::DBHOST, Config::DBNAME), Config::DBUSER, Config::DBPASSWORD);
            });

            $app->register('um', function () use ($app) {
                return new UserManager(new UserRepository($app->pdo));
            });

            $app->register('twig', function () {
                $loader = new \Twig_Loader_Filesystem('View', '..');
                return new \Twig_Environment($loader);
            });
        });
    }
}
