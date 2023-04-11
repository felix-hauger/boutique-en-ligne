<?php

namespace App\Model;

use \App\Config\DbConnection;

abstract class AbstractModel
{
    /**
     * @var ?PDO used to connect to database
     */
    private ?\PDO $_pdo = null;

    /**
     * @var string identifies child class table name
     */
    private string $_table;

    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();
    }

    /**
     * @return array of sql results
     */
    public function findAll(): array
    {
        $sql = 'SELECT * FROM ' . $this->_table;

        $select = $this->_pdo->prepare($sql);

        if ($select->execute()) {
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function find(int $id): array
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        if ($select->execute()) {
            return $select->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        return $select->execute();
    }
}

