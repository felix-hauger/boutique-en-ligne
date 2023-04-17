<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

// use App\Entity\User as UserEntity;


class User extends AbstractModel
{
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

    public function update(\App\Entity\User $user)
    {
        $sql = 'UPDATE user SET login = :login, password = :password, email = :email, username = :username, firstname = :firstname, lastname = :lastname, role_id = :role_id WHERE id = :id';

        $update = $this->_pdo->prepare($sql);

        $update->bindValue(':login', $user->getLogin());
        $update->bindValue(':password', $user->getPassword());
        $update->bindValue(':email', $user->getEmail());
        $update->bindValue(':username', $user->getUsername());
        $update->bindValue(':firstname', $user->getFirstname());
        $update->bindValue(':lastname', $user->getLastname());
        $update->bindValue(':role_id', $user->getRoleId());
        $update->bindValue(':id', $user->getId());

        return $update->execute();
    }

    /**
     * check if value exists in one field in database
     * @param string $column the name of the column in the table
     * @param string $value the value to search
     * @return int|false id if row is found, else false
     */
    public function findIdWithField(string $column, string $value) : ?int
    {
        // $sql = 'SELECT COUNT(id) FROM user WHERE ' . $column . ' = :' . $column;
        $sql = 'SELECT id FROM user WHERE ' . $column . ' = :' . $column;

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        // var_dump($select);

        return $select->execute() ? $select->fetchColumn() : null;
    }

    public function isFieldInDb(string $column, string $value)
    {
        $sql = 'SELECT COUNT(id) FROM user WHERE ' . $column . ' = :' . $column;

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':' . $column, $value);

        return $select->fetchColumn() > 0;
    }
}

$user = new User();

// var_dump($user->_table);
// var_dump($user->findAll());