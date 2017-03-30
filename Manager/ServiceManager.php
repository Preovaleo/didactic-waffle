<?php
namespace Minifier\Manager;

use Klein\Klein;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;
use Minifier\Config\Config;

class ServiceManager
{

    public static function initService(Klein $klein)
    {
        $klein->respond(function (Request $request, Response $reponse, ServiceProvider $service, App $app) {
            $app->register('pdo', function() {
                return new \PDO(sprintf('mysql:host=%s;dbname=%s', Config::DBHOST, Config::DBNAME), Config::DBUSER, Config::DBPASSWORD);
            });
        });
    }
}
