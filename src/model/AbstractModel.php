<?php

namespace App\Model;

use PDO;
use App\Config\DbConnection;

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
        $this->_table = '`' . strtolower(array_pop($class)) . '`';

        // ! WARNING: at current version you must still define $_table property
        // ! WARNING: in child class if the model / table is more than 1 word long
        // ! WARNING: exemple: model => UserAddress, table name => user_address
    }

    /**
     * @return array|false Array of sql result if request executed successfully and found, else false
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
     * @return array|false Row from database if request executed successfully and found, else false
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

    public function isInDb(int $id)
    {
        $sql = 'SELECT COUNT(id) FROM ' . $this->_table . ' WHERE id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        $select->execute();

        return $select->fetchColumn() > 0;
    }

    public function isFieldInDb(string $column, mixed $value, bool $case_sensitive = false)
    {
        if ($case_sensitive) {
            $sql = 'SELECT COUNT(id) FROM ' . $this->_table . ' WHERE BINARY ' . $column . ' = :' . $column;
        } else {
            $sql = 'SELECT COUNT(id) FROM ' . $this->_table . ' WHERE UPPER(' . $column . ') LIKE UPPER(:' . $column . ')';
        }

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        $select->execute();

        return $select->fetchColumn() > 0;
    }

    /**
     * check if value exists in one field in database
     * @param string $column The name of the column in the table
     * @param string $value The value to search
     * @param bool $case_sensitive Determine if the query is case sensitive or not
     * @return int|false The id if row is found, else false
     */
    public function findIdWithField(string $column, string $value, bool $case_sensitive = false) : ?int
    {
        if ($case_sensitive) {
            $sql = 'SELECT id FROM ' . $this->_table . ' WHERE BINARY ' . $column . ' = :' . $column;
        } else {
            $sql = 'SELECT id FROM ' . $this->_table . ' WHERE UPPER(' . $column . ') LIKE UPPER(:' . $column . ')';
        }

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        return $select->execute() ? $select->fetchColumn() : null;
    }

    /**
     * @param array $criteria Associative array of column names & field values filtering results
     * 
     * @return array|false SQL results if request is successfully executed
     */
    public function findAllBy(array $criteria): array|false
    {
        $sql = 'SELECT * FROM ' . $this->_table . ' WHERE ';

        foreach ($criteria as $column_name => $value) {
            $sql .= $column_name . ' = :' . $column_name . ' AND ';
        }

        $sql = substr($sql, 0, -5);

        $select = $this->_pdo->prepare($sql);

        $select->execute($criteria);

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return PDO $this->_pdo to get Database connection infos
     */
    public function getPdo()
    {
        return $this->_pdo;
    }
}