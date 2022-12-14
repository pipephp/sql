<?php

namespace Pipe;

use PDO;

class SQL
{
    public $connection = null;
    public $stmt = null;
    public $lastResult = false;

    public function connect(
        string $host,
        string $user,
        string $password,
        string $dbname,
        int $port = 3306,
        string $encoding = "utf8"
    ): self
    {
        $connection = new PDO(
            "mysql:dbname=$dbname;host=$host;charset=$encoding;port=$port",
            $user,
            $password,
        );

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->connection = $connection;

        return $this;
    }

    public function raw(string $sql)
    {
        $this->lastResult = $this->stmt = $this->connection->query($sql);
        return $this;
    }

    public function query(string $sql, array $args = [])
    {
        $this->stmt = $this->connection->prepare($sql);
        $this->lastResult = $this->stmt->execute($args);
        return $this;
    }

    public function all()
    {
        return $this->stmt->fetchAll();
    }

    public function first()
    {
        return $this->stmt->fetch();
    }

    public function one()
    {
        return $this->stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }

    public function lastResult(): bool
    {
        return $this->lastResult;
    }
}
