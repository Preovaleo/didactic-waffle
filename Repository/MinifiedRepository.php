<?php
namespace Minifier\Repository;

use Minifier\Exception\MySQLException;

class MinifiedRepository
{

    /**
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     *
     * @param string $token
     * @return Minifier\Model\Minified
     * @throws MySQLException
     */
    public function fetchbyToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM minified WHERE token = :token LIMIT 1');
        $stmt->bindValue(':token', $token);
        if (!$stmt->execute()){
            throw new MySQLException($stmt);
        }
        return $stmt->fetchObject('Minifier\Model\Minified');
    }
}
