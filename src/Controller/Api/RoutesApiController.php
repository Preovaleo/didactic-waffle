<?php
namespace Minifier\Controller\Api;

use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;
use Minifier\Manager\JsonRepManager;
use Minifier\Repository\MinifiedRepository;

class RoutesApiController
{

    public static function getAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedin()) {
            JsonRepManager::isDisconnected($response);
            return;
        }

        $limit = 10;

        $offset = ((int) $request->param('page', 0)) * $limit;

        $minifiedR = new MinifiedRepository($app->pdo);
        $mins = $minifiedR->fetchAll($limit, $offset);
        $nbr = $minifiedR->count();

        JsonRepManager::success($response, array(
            'mins' => $mins,
            'nbr' => $nbr,
            'limit' => $limit
        ));
    }
}
