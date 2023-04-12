<?php

namespace App\Controller;

use \App\Model\User as UserModel;
use \App\Entity\User as UserEntity;
use Exception;

class User
{

    /**
     * @param string $login to auth
     * @param string $password to auth, do not store in session
     * @param string $email address personal info, can be used to send emails
     * @param string $username visible to other users
     * @param string $firstname personal info
     * @param string $lastname personal info
     * 
     * @return bool when User model uses create method, depending if request is successfull or not
     */
    public function register(string $login, string $password, string $password_confirm, string $email, string $username, string $firstname, string $lastname): mixed
    {
        // register user with User model & entity
        // instanciate User model
        $user_model = new UserModel();

        // ! must use methods to test inputs

        if ($password === $password_confirm) {
            try {
                // instanciate User entity
                $user_entity = new UserEntity();

                $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);

                // hydrate User entity properties
                $user_entity
                    ->setLogin($login)
                    ->setPassword($password)
                    ->setEmail($email)
                    ->setUsername($username)
                    ->setFirstname($firstname)
                    ->setLastname($lastname);

                // send User entity to model to create use in database
                // return bool depending if model successfully created user or not
                return $user_model->create($user_entity);
            } catch (\PDOException $e) {
                echo $e->getMessage();
                // var_dump($e);
            }
        } else {
            throw new Exception('Le mot de passe et la confirmation doivent être identiques');
        }
    }

    /**
     * @param string $login to auth
     * @param string $password to auth, do not store in session
     * 
     * @return true if user infos are retrieved using User model find($id) method
     */
    public function connect(string $login, string $password): mixed
    {
        // retrieve user infos, hydrate User entity & store it in session

        $user_model = new UserModel();

        // retrieve user id if it exists
        $id = $user_model->findIdWithField('login', $login);

        if ($id) {
            $db_user = $user_model->find($id);

            // var_dump($db_user);

            if (password_verify($password, $db_user['password']) || $password === $db_user['password']) {
                // instanciate User entity
                $user_entity = new UserEntity();

                // hydrate User entity properties
                $user_entity
                    ->setId($db_user['id'])
                    ->setLogin($db_user['login'])
                    ->setEmail($db_user['email'])
                    ->setUsername($db_user['username'])
                    ->setFirstname($db_user['firstname'])
                    ->setLastname($db_user['lastname'])
                    ->setRoleId($db_user['role_id']);

                if (session_status() === PHP_SESSION_ACTIVE) {
                    // store entity in session to use its structure & methods
                    $_SESSION['user'] = $user_entity;
                }

                // return true & stop executing method
                return true;
            }
        }

        // generic exception
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
     * @return bool depending if model successfully deleted user or not
     */
    public function delete($id): bool
    {
        $user_model = new UserModel();

        return $user_model->delete($id);
    }
}