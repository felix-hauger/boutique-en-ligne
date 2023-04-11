<?php

namespace App\Model;

class User extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'user';
    }

    /**
     * insert user in database
     * @return bool depending if request is successfull or not
     */
    public function create(string $login, string $password, string $email, string $username, string $firstname, string $lastname): bool
    {
        $sql = 'INSERT INTO user (login, password, email, username, firstname, lastname, created_at, role_id) VALUES (:login, :password, :email, :username, :firstname, :lastname, NOW(), 2)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':login', $login);
        $insert->bindParam(':password', $password);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':username', $username);
        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);

        return $insert->execute();
    }

    public function isFieldInDb(string $column, string $value)
    {
        $sql = 'SELECT COUNT(id) FROM user WHERE ' . $column . ' = :' . $column;

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        return $select->fetchColumn() > 0;
    }
}