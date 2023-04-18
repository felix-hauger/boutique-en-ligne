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


}

$user = new User();

// var_dump($user->findIdWithField('login', 'toto'));

// var_dump($user->isFieldInDb('id', 1));

// var_dump($user->_table);
// var_dump($user->findAll());