<?php
namespace Minifier\Controller;

use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;
use Minifier\Repository\MinifiedRepository;

class RedirectController
{

    public static function redirectAction(Request $request, Response $reponse, ServiceProvider $service, App $app)
    {
        $minifiedR = new MinifiedRepository($app->pdo);
        $minified = $minifiedR->fetchbyToken($request->token);

        if ($minified === false) {
            return 'Wrong Token';
        }
        $reponse->redirect($minified->url);
    }
}
