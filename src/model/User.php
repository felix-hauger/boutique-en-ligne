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
    public function create(string $login, string $password, string $email, string $firstname, string $lastname): bool
    {
        $sql = 'INSERT INTO user (title, content, image, creation_date, user_id, category_id) VALUES (:title, :content, :image, NOW(), :user_id, :category_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':login', $login);
        $insert->bindParam(':password', $password);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);

        return $insert->execute();
    }
}



