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
        if(!$app->um->isLoggedIn()){
            $response->redirect('/user/login');
            return;
        }

        return $app->twig->render('Admin/index.twig');
    }
}
