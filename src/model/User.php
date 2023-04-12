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
     * @param App\Entity\User $user Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\User $user): bool
    {
        $sql = 'INSERT INTO user (login, password, email, username, firstname, lastname, created_at, role_id) VALUES (:login, :password, :email, :username, :firstname, :lastname, NOW(), 2)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':login', $user->getLogin());
        $insert->bindValue(':password', $user->getPassword());
        $insert->bindValue(':email', $user->getEmail());
        $insert->bindValue(':username', $user->getUsername());
        $insert->bindValue(':firstname', $user->getFirstname());
        $insert->bindValue(':lastname', $user->getLastname());

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