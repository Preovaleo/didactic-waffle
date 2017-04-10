<?php
namespace Minifier\Manager;

class PutManager
{

    private $array;

    public function __construct()
    {
        parse_str(file_get_contents("php://input"), $this->array);
    }

    public function get($key, $default)
    {
        if (isset($this->array[$key])) {
            return $this->array[$key];
        } else {
            return $default;
        }
    }
}
