<?php

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Entity\Cart;
use App\Model\User as UserModel;
use App\Entity\User as UserEntity;
use App\Model\Cart as CartModel;
use Exception;

class User extends AbstractController
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
     * @return string Exception message when an Exception is catched from the model
     */
    public function register(string $login, string $password, string $password_confirm, string $email, string $username, string $firstname, string $lastname): bool|string
    {
        // Filter method arguments & replace them in the function environment
        extract($this->filterMethodArgs(__CLASS__, __FUNCTION__, func_get_args()));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email invalide');
        }

        // var_dump($user_arr);
        // die();

        // Register user with User model & entity
        if ($password === $password_confirm) {
            // Instanciate User model
            $user_model = new UserModel();

            // Begin transaction
            $user_model->getPdo()->beginTransaction();

            try {
                // Instanciate User entity
                $user_entity = new UserEntity();

                // Hash password to store it in db securely
                $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);

                // Hydrate User entity properties
                $user_entity
                    ->setLogin($login)
                    ->setPassword($password)
                    ->setEmail($email)
                    ->setUsername($username)
                    ->setFirstname($firstname)
                    ->setLastname($lastname);

                // Create user in database
                $user_model->create($user_entity);

                // Get the id of the new registered user
                $db_user_id = $user_model->getPdo()->lastInsertId();

                // Instanciate Cart model to insert a cart in database
                $cart_model = new CartModel();

                // Instanciate Cart entity to hydrate with properties
                $cart = new Cart();

                // Bind cart to user
                $cart->setUserId($db_user_id);

                // Create user linked cart in database
                $cart_model->create($cart);

                // Return bool depending if the transaction is completed successfully
                // And user and cart are inserted in database
                return $user_model->getPdo()->commit();
            } catch (\PDOException $e) {
                // If an exception is thrown rollback the transaction
                $user_model->getPdo()->rollBack();

                throw new \Exception($e);
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


    public function getAllInfo()
    {
        $product_model = new UserModel();
        return $product_model->findAll();
       
    }

    public function checkPasswordStrength(string $password) {
        // check if password is powerful enough with regex
    }

    public function isAlphaNumeric(string $string)
    {
        // check if string is alphanumeric, with regex or functions
    }

    public function update(\App\Entity\User $user)
    {
        $user_model = new UserModel();

        $db_user = $user_model->find($user->getId());

        var_dump($db_user);

        if ($db_user) {
            $user_model->update($user);
            // if ($user->getFirstname() !== $db_user['firstname']) {
                
            // }
        }
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

// $user = new User();
// try {
//     $user->register('<b>a</b>', 'a', 'a', 'a@b.c', 'a', 'a', 'a');
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
// $user_entity = new UserEntity();

// $user_entity
//     ->setId(34)
//     ->setLogin('login')
//     ->setPassword('password')
//     ->setEmail('email')
//     ->setUsername('username')
//     ->setFirstname('firstname')
//     ->setLastname('lastname')
//     ->setRoleId(1);

// $user->update($user_entity);