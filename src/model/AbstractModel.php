<?php

namespace App\Model;

use \App\Config\DbConnection;

abstract class AbstractModel
{
    /**
     * @var ?PDO used to connect to database
     */
    protected ?\PDO $_pdo = null;

    /**
     * @var string identifies child class table name
     */
    protected string $_table;

    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();
    }

    /**
     * @return array of sql results
     */
    public function findAll(): ?array
    {
        $sql = 'SELECT * FROM ' . $this->_table;

        $select = $this->_pdo->prepare($sql);

        if ($select->execute()) {
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    /**
     * @param int id representing id column in database
     * @return array row from database
     */
    public function find(int $id): ?array
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        if ($select->execute()) {
            return $select->fetch(\PDO::FETCH_ASSOC);
        }
    }

    /**
     * @param int id representing id column in database
     * @return bool depending if request is successfull or not
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        return $select->execute();
    }
}

