<?php
namespace Minifier\Repository;

use Minifier\Exception\MySQLException;
use Minifier\Model\Minified;
use Minifier\Exception\DuplicateKeyException;

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
     * @return Minified
     * @throws MySQLException
     */
    public function fetchbyToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM minified WHERE token = :token LIMIT 1;');
        $stmt->bindValue(':token', $token);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $stmt->fetchObject('Minifier\Model\Minified');
    }

    /**
     *
     * @param int $id
     * @return Minified
     * @throws MySQLException
     */
    public function fetch($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM minified WHERE id = :id LIMIT 1;');
        $stmt->bindValue(':id', $id);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $stmt->fetchObject('Minifier\Model\Minified');
    }

    /**
     *
     * @param int $limit
     * @param int $offset
     * @return Minified
     * @throws MySQLException
     */
    public function fetchAll($limit = 10, $offset = 0)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM minified LIMIT :limit OFFSET :offset;');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'Minifier\Model\Minified');
    }

    /**
     *
     * @param Minified $min
     * @return Minified
     * @throws DuplicateKeyException
     * @throws MySQLException
     */
    public function add(Minified $min)
    {
        $test = $this->fetchbyToken($min->token);
        if (!$test === false) {
            throw new DuplicateKeyException('this token is already used');
        }

        $stmt = $this->pdo->prepare('INSERT INTO minified(token, url) VALUES (:token, :url);');
        $stmt->bindValue(':token', $min->token);
        $stmt->bindValue(':url', $min->url);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        $min->id = $this->pdo->lastInsertId();
        return $min;
    }

    /**
     *
     * @param Minified $min
     * @return Minified
     * @throws DuplicateKeyException
     * @throws MySQLException
     */
    public function update(Minified $min)
    {
        $test = $this->fetchbyToken($min->token);
        if (!(($test === false) || ($test !== false) && ($test->id === $min->id))) {
            throw new DuplicateKeyException('this token is already used');
        }

        $stmt = $this->pdo->prepare('UPDATE minified SET token = :token, url = :url WHERE id = :id;');
        $stmt->bindValue(':token', $min->token);
        $stmt->bindValue(':url', $min->url);
        $stmt->bindValue(':id', $min->id);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $min;
    }

    /**
     *
     * @param Minified $min
     * @throws MySQLException
     */
    public function delete(Minified $min)
    {
        $stmt = $this->pdo->prepare('DELETE FROM minified WHERE id = :id');
        $stmt->bindValue(':id', $min->id);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
    }

    /**
     *
     * @return int
     * @throws MySQLException
     */
    public function count()
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) as nbr FROM minified');
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return ((int) $stmt->fetchColumn());
    }
}
