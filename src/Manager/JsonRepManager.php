<?php
namespace Minifier\Manager;

class JsonRepManager
{
    public static function isDisconnected(\Klein\Response $response)
    {
        self::respond($response, false, 'Disconnected');
    }

    private static function respond(\Klein\Response $response, $success, $data)
    {
        $rep = array(
            'success' => $success,
            'data' => $data
        );
        $response->json($rep);
    }

    public static function fail(\Klein\Response $response, $message)
    {
        self::respond($response, false, $message);
    }

    public static function success(\Klein\Response $response, $data)
    {
        self::respond($response, true, $data);
    }
}
