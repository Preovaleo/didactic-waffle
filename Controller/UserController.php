<?php
namespace Minifier\Controller;

use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;

class UserController
{

    public static function loginAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        var_dump($_SESSION);

        if ($app->um->isLoggedIn()) {
            $response->redirect('/admin');
            return;
        }

        $errors = array();

        if ($request->method('POST')) {

            $username = $request->param('username', '');
            $password = $request->param('password', '');

            if ($app->um->login($username, $password)) {
                $response->redirect('/admin');
                return;
            } else {
                $errors[] = 'Bad username or password';
            }
        }

        return $app->twig->render('User/login.twig', array(
                'errors' => $errors
        ));
    }

    public static function logoutAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedIn()) {
            $response->redirect('/user/login');
            return;
        }
        $app->um->logout();
        $response->redirect('/');
    }
}
