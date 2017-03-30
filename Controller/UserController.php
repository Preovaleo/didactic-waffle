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
}