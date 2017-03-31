<?php
namespace Minifier\Controller\Api;

use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Klein\App;
use Minifier\Repository\MinifiedRepository;
use Minifier\Manager\JsonRepManager;
use Minifier\Model\Minified;
use Minifier\Manager\PutManager;

class RouteApiController
{

    public static function getAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedin()) {
            JsonRepManager::isDisconnected($response);
            return;
        }

        $id = $request->param('id', false);
        if ($id === false) {
            JsonRepManager::fail($response, 'ID NOT FOUND');
            return;
        }

        $minifiedR = new MinifiedRepository($app->pdo);
        $min = $minifiedR->fetch($id);

        if ($min === false) {
            JsonRepManager::fail($response, 'NOT FOUND');
            return;
        }

        JsonRepManager::success($response, $min);
    }

    public static function postAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedin()) {
            JsonRepManager::isDisconnected($response);
            return;
        }

        $min = new Minified();
        $min->token = $request->param('token', false);
        if ($min->token === false) {
            JsonRepManager::fail($response, 'TOKEN NOT FOUND');
            return;
        }
        $min->url = $request->param('url', false);
        if ($min->url === false) {
            JsonRepManager::fail($response, 'URL NOT FOUND');
            return;
        }
        $minifiedR = new MinifiedRepository($app->pdo);
        try {
            $min = $minifiedR->add($min);
            JsonRepManager::success($response, $min);
        } catch (\Exception $ex) {
            JsonRepManager::fail($response, $ex->getMessage());
        }
    }

    public static function putAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedin()) {
            JsonRepManager::isDisconnected($response);
            return;
        }

        $putM = new PutManager();
        $minifiedR = new MinifiedRepository($app->pdo);
        $id = $request->param('id', false);

        if ($id === false) {
            JsonRepManager::fail($response, 'ID NOT FOUND');
            return;
        }

        $min = $minifiedR->fetch($id);

        if ($min === false) {
            JsonRepManager::fail($response, 'NOT FOUND');
            return;
        }

        $min->token = $putM->get('token', $min->token);
        $min->url = $putM->get('url', $min->url);

        try {
            $min = $minifiedR->update($min);
            JsonRepManager::success($response, $min);
        } catch (\Exception $ex) {
            JsonRepManager::fail($response, $ex->getMessage());
        }
    }

    public static function deleteAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        if (!$app->um->isLoggedin()) {
            JsonRepManager::isDisconnected($response);
            return;
        }

        $minifiedR = new MinifiedRepository($app->pdo);
        $id = $request->param('id', false);

        if ($id === false) {
            JsonRepManager::fail($response, 'ID NOT FOUND');
            return;
        }

        $min = $minifiedR->fetch($id);

        if ($min === false) {
            JsonRepManager::fail($response, 'NOT FOUND');
            return;
        }

        try {
            $min = $minifiedR->delete($min);
            JsonRepManager::success($response, $min);
        } catch (\Exception $ex) {
            JsonRepManager::fail($response, $ex->getMessage());
        }
    }
}
