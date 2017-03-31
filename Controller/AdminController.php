<?php
namespace Minifier\Controller;

use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;

class AdminController
{

    public static function indexAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        return $app->twig->render('Admin/index.twig');
    }
}
