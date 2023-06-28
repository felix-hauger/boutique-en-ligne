<?php

namespace App\Model;

class UserAddress extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();

        $this->_table = 'user_address';
    }

    /**
     * Insert user_address in database
     * @param App\Entity\UserAddress $user_address_entity Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\UserAddress $user_address_entity)
    {
        $sql = 'INSERT INTO user_address (alias, address_line_1, address_line_2, city, postal_code, country, phone, mobile, user_id) VALUES (:alias, :address_line_1, :address_line_2, :city, :postal_code, :country, :phone, :mobile, :user_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':alias', $user_address_entity->getAlias());
        $insert->bindValue(':address_line_1', $user_address_entity->getAddressLine1());
        $insert->bindValue(':address_line_2', $user_address_entity->getAddressLine2());
        $insert->bindValue(':city', $user_address_entity->getCity());
        $insert->bindValue(':postal_code', $user_address_entity->getPostalCode());
        $insert->bindValue(':country', $user_address_entity->getCountry());
        $insert->bindValue(':phone', $user_address_entity->getPhone());
        $insert->bindValue(':mobile', $user_address_entity->getMobile());
        $insert->bindValue(':user_id', $user_address_entity->getUserId());

        return $insert->execute();
    }
}