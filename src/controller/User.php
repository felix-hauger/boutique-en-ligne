<?php

namespace App\Controller;

use \App\Model\User as UserModel;
use \App\Entity\User as UserEntity;

class User
{
    public function register(string $login, string $password, string $password_confirm, string $email, string $username, string $firstname, string $lastname)
    {
        // register user with User model & entity
        $user_model = new UserModel();

        try {
            $user_entity = new UserEntity();

            $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);

            $user_entity
                ->setLogin($login)
                ->setPassword($password)
                ->setEmail($email)
                ->setUsername($username)
                ->setFirstname($firstname)
                ->setLastname($lastname);

            $user_model->create($user_entity);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            var_dump($e);
        }
    }

    public function connect(string $login, string $password)
    {
        // retrieve user infos, hydrate User entity & store it in session
    }

    public function checkPasswordStrength(string $password) {
        // check if password is powerful enough with regex
    }

    public function logout()
    {
        // disconnect user
    }

    public function delete($id)
    {
        // delete user, then disconnect
    }

    public function isAlphaNumeric(string $string)
    {
        // check if string is alphanumeric, with regex or functions
    }
}