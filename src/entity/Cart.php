<?php

namespace App\Entity;

use DateTime;

class Cart
{
    /**
     * @var int Identifies entity
     */
    private int $_id;
    
    /**
     * @var Datetime The creation date of the cart 
     */
    private DateTime $_created_at;
    
    /**
     * @var Datetime The last time when the cart was updated
     */
    private DateTime $_updated_at;

    /**
     * @var int Identifies cart owner
     */
    private int $_user_id;

    /**
     * Get the value of _id
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     */
    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }

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
    public function setCreatedAt(DateTime $_created_at): self
    {
        $this->_created_at = $_created_at;

        return $this;
    }

    /**
     * Get the value of _updated_at
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->_updated_at;
    }

    /**
     * Set the value of _updated_at
     */
    public function setUpdatedAt(DateTime $_updated_at): self
    {
        $this->_updated_at = $_updated_at;

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
    public function setUserId(int $_user_id): self
    {
        $this->_user_id = $_user_id;

        return $this;
    }
}