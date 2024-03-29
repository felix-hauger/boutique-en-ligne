<?php

namespace App\Controller;

use App\Controller\Cart as CartController;
use App\Model\CartProduct;
use App\Entity\Cart;
use App\Model\User as UserModel;
use App\Entity\User as UserEntity;
use App\Entity\UserAddress;
use App\Model\Cart as CartModel;
use App\Model\UserAddress as UserAddressModel;
use Exception;

class User extends AbstractController
{
    /**
     * @param string $login to auth
     * @param string $password to auth
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
     * Hydrate User entity with retrieved user infos from db & store it in session
     * @param string $login to auth
     * @param string $password to auth, do not store in session
     * 
     * @return true if user infos are retrieved using User model find($id) method
     */
    public function connect(string $login, string $password): mixed
    {
        // Filter method arguments & replace them in the function environment
        extract($this->filterMethodArgs(__CLASS__, __FUNCTION__, func_get_args()));

        $user_model = new UserModel();

        // Retrieve user id if it exists
        $id = $user_model->findIdWithField('login', $login);

        if ($id) {
            $db_user = $user_model->find($id);

            if (password_verify($password, $db_user['password'])) {
                // Instanciate User entity
                $user_entity = new UserEntity();

                // Hydrate User entity properties
                $user_entity->hydrate($db_user);

                if (session_status() === PHP_SESSION_ACTIVE) {
                    // Store entity in session to use its structure & methods
                    $_SESSION['user'] = $user_entity;

                    $cart_controller = new CartController();

                    // Transfer items to logged user from cookies to database
                    $cart_controller->transferCookieCartItemsToLoggedUser();

                    header('Location: ' . $_SESSION['url']);
                }

                // Return true & stop executing method
                return true;
            }
        }

        // Incorrect login and/or password
        throw new \Exception('identifiants incorrects');
    }

    public function getAllInfo()
    {
        $product_model = new UserModel();
        return $product_model->findAll();
       
    }

    public function checkPasswordStrength(string $password)
    {
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

        if ($db_user) {
            $user_model->update($user);
        }
    }

    /**
     * Disconnect user
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

    public function updateRole($id,$new_role_id)
    {
        $user_model = new UserModel();
    
        return $user_model->updateRole($id,$new_role_id);
    }

    public function countCartItems(int $id)
    {
        $cart_model = new CartModel();

        $cart_id = $cart_model->findIdWithField('user_id', $id, true);

        $cart_product = new CartProduct();

        return $cart_product->countByCart($cart_id);
    }

    public function addAddress(string $alias, string $address_line1, ?string $address_line2, string $city, string $postal_code, string $country, string $phone, ?string $mobile, int $user_id)
    {
        // Filter method arguments
        $args = $this->filterMethodArgs(__CLASS__, __FUNCTION__, func_get_args());

        $regex_phone = '/^(\+33|0)[1-9](\d{2}){4}$/';

        foreach ($args as $key => $arg) {
            if ($key !== 'address_line2' && $key !== 'mobile') {
                if (empty($arg)) {
                    throw new Exception('Veuillez remplir tous les champs obligatoires.');
                }
            }

            if ($key === 'phone' || $key === 'mobile') {
                if (strlen($arg) > 0) {
                    if (!preg_match($regex_phone, $arg)) {
                        $message = ' Formats acceptés : +331 23 45 67 89, +33123456789, 01 23 45 67 89, 0123456789';
                        
                        // Customize message depending if it is mobile
                        $message = $key === 'mobile' ? 'Format téléphone mobile non valide.' . $message : 'Format téléphone non valide.' . $message;

                        throw new Exception($message);
                    }
                }
            }
        }

        $user_address_entity = new UserAddress();
        
        $user_address_entity->hydrate($args);

        $user_address_model = new UserAddressModel();

        return $user_address_model->create($user_address_entity);
    }

    /**
     * @param int $id The user id
     * 
     * @return array|false List of UserAddress Entities hydrated with sql results, false if no result found
     */
    public function getAllAddresses(int $id): array|false
    {
        $user_address_model = new UserAddressModel();

        $address_list = $user_address_model->findAllBy(['user_id' => $id]);

        if ($address_list) {
            // Instanciate and hydrate entities with returned array of addresses
            $address_entity_list = array_map(
                function($address) {
                    $user_address_entity = new UserAddress();
        
                    $user_address_entity->hydrate($address);
    
                    return $user_address_entity;
                },
    
                $address_list
            );
    
            return $address_entity_list;
        } else {
            return false;
        }
    }

    public function editAddress(int $id, string $alias, string $address_line1, ?string $address_line2, string $city, string $postal_code, string $country, string $phone, ?string $mobile)
    {
        // Filter method arguments
        $args = $this->filterMethodArgs(__CLASS__, __FUNCTION__, func_get_args());

        $regex_phone = '/^(\+33|0)[1-9](\d{2}){4}$/';

        foreach ($args as $key => $arg) {
            if ($key !== 'address_line2' && $key !== 'mobile') {
                if (empty($arg)) {
                    throw new Exception('Veuillez remplir tous les champs obligatoires.');
                }
            }

            if ($key === 'phone' || $key === 'mobile') {
                if (strlen($arg) > 0) {
                    if (!preg_match($regex_phone, $arg)) {
                        $message = ' Formats acceptés : +331 23 45 67 89, +33123456789, 01 23 45 67 89, 0123456789';
                        
                        // Customize message depending if it is mobile
                        $message = $key === 'mobile' ? 'Format téléphone mobile non valide.' . $message : 'Format téléphone non valide.' . $message;

                        throw new Exception($message);
                    }
                }
            }
        }

        $user_address_entity = new UserAddress();
        
        $user_address_entity->hydrate($args);

        $user_address_model = new UserAddressModel();

        return $user_address_model->update($user_address_entity);
    }

}