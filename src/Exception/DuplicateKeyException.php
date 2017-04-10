<?php
namespace Minifier\Exception;

class DuplicateKeyException extends \Exception
{

    public function __construct($message)
    {
        parent::__construct($message);
    }
}
