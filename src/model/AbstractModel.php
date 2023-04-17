<?php

namespace App\Model;

use PDO;
use \App\Config\DbConnection;

abstract class AbstractModel
{
    /**
     * @var ?PDO used to connect to database
     */
    protected ?PDO $_pdo = null;

    /**
     * @var string identifies child class table name
     */
    protected string $_table;

    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();

        // get child class (on the context where it is called)
        $class = get_class($this);

        // explode the namespace into an array
        $class = explode('\\', $class);

        // set $_table property value to the last array entry case lowered
        $this->_table = strtolower(array_pop($class));

        // ! WARNING: at current version you must still define $_table property
        // ! WARNING: in child class if the model / table is more than 1 word long
        // ! WARNING: exemple: model => UserAddress, table name => user_address
    }

    /**
     * @return array of sql results if request executed successfully
     */
    public function findAll(): array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table;

        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int id representing id column in database
     * @return array row from database if request executed successfully
     */
    public function find(int $id): array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
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

    public function isFieldInDb(string $column, string $value)
    {
        $sql = 'SELECT COUNT(id) FROM ' . $this->_table . ' WHERE ' . $column . ' = :' . $column;

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        $select->execute();

        return $select->fetchColumn() > 0;
    }
}

