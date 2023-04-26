<?php

namespace App\Entity;

use DateTime;

class Order extends AbstractEntity
{
    /**
     * @var int Identifies entity
     */
    protected int $_id;
    
    /**
     * @var Datetime The creation date of the order 
     */
    protected DateTime $_created_at;
    
    /**
     * @var Datetime The last time when the cart was updated
     */
    
    protected int $_user_id;

    /**
     * Get the value of _created_at
     */
    public function getCreatedAt(): DateTime
    {
        return $this->_created_at;
    }

    /**
     * Set the value of _created_at
     */
    public function setCreatedAt(DateTime $created_at): self
    {
        $this->_created_at = $created_at;

        return $this;
    }


    /**
     * Set the value of _updated_at
     */
    public function setUpdatedAt(?DateTime $updated_at): self
    {
        $this->_updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of _user_id
     */
    public function getUserId(): int
    {
        return $this->_user_id;
    }

    /**
     * Set the value of _user_id
     */
    public function setUserId(int $user_id): self
    {
        $this->_user_id = $user_id;

        return $this;
    }
}