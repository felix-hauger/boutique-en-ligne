<?php

namespace App\Controller;

use \App\Model\User as UserModel;
use \App\Entity\User as UserEntity;
use Exception;

class User
{
    public function register(string $login, string $password, string $password_confirm, string $email, string $username, string $firstname, string $lastname)
    {
        // register user with User model & entity
        $user_model = new UserModel();

        if ($password === $password_confirm) {
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
        } else {
            throw new Exception('Le mot de passe et la confirmation doivent être identiques');
        }
    }

    public function connect(string $login, string $password)
    {
        // retrieve user infos, hydrate User entity & store it in session

        $user_model = new UserModel();

        // retrieve user id if it exists
        $id = $user_model->findIdWithField('login', $login);

        if ($id) {
            $db_user = $user_model->find($id);

            // var_dump($db_user);

            if (password_verify($password, $db_user['password']) || $password === $db_user['password']) {
                $user_entity = new UserEntity();

                $user_entity
                    ->setId($db_user['id'])
                    ->setLogin($db_user['login'])
                    ->setEmail($db_user['email'])
                    ->setUsername($db_user['username'])
                    ->setFirstname($db_user['firstname'])
                    ->setLastname($db_user['lastname'])
                    ->setRoleId($db_user['role_id']);

                if (session_status() === PHP_SESSION_ACTIVE) {
                    $_SESSION['user'] = $user_entity;
                }
                return true;
            }
        }

        throw new \Exception('identifiants incorrects');
    }

    public function checkPasswordStrength(string $password) {
        // check if password is powerful enough with regex
    }

    public function isAlphaNumeric(string $string)
    {
        // check if string is alphanumeric, with regex or functions
    }

    /**
     * disconnect user
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * @param int id representing user id
     * @return bool depending if model successfully deleted or not
     */
    public function delete($id): bool
    {
        $user_model = new UserModel();

        return $user_model->delete($id);
    }
}