<?php
namespace Minifier\Exception;

use Minifier\Config\Config;

class MySQLException extends \Exception
{

    public function __construct(\PDOStatement $stmt)
    {
        $arrayError = $stmt->errorInfo();
        if (Config::DEBUG) {
            $message = sprintf('MYSQL ERROR %d => %s', $arrayError[0], $arrayError[2]);
        } else {
            $message = 'Error With the MYSQL driver';
        }
        parent::__construct($message);
    }
}
