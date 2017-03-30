<?php
namespace Minifier\Repository;

use Minifier\Model\User;

class UserRepository
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
     * @param string $username
     * @return User
     * @throws MySQLException
     */
    public function fetchbyUsername($username)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE username = :username LIMIT 1;');
        $stmt->bindValue(':username', $username);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $stmt->fetchObject('Minifier\Model\User');
    }

    /**
     *
     * @param int $limit
     * @param int $offset
     * @return User[]
     * @throws MySQLException
     */
    public function fetchAll($limit = 10, $offset = 0)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user LIMIT :limit OFFSET :offset;');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'Minifier\Model\User');
    }

    /**
     *
     * @param User $user
     * @return User
     * @throws MySQLException
     */
    public function add(User $user)
    {
        $stmt = $this->pdo->prepare('INSERT INTO user (username, hash) VALUES (:username, :hash);');
        $stmt->bindValue(':username', $user->username);
        $stmt->bindValue(':hash', $user->hash);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        $user->id = $this->pdo->lastInsertId();
        return $user;
    }

    /**
     *
     * @param User $user
     * @return User
     * @throws MySQLException
     */
    public function update(User $user)
    {
        $stmt = $this->pdo->prepare('UPDATE user SET username = :username, hash = :hash WHERE id = :id;');
        $stmt->bindValue(':username', $user->username);
        $stmt->bindValue(':hash', $user->hash);
        $stmt->bindValue(':id', $user->id);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return $user;
    }

    /**
     *
     * @param User $user
     * @return boolean
     * @throws MySQLException
     */
    public function delete(User $user)
    {
        $stmt = $this->pdo->prepare('DELETE FROM user WHERE id = :id;');
        $stmt->bindValue(':id', $user->id);
        if (!$stmt->execute()) {
            throw new MySQLException($stmt);
        }
        return true;
    }
}
