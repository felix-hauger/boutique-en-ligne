<?php

namespace App\Entity;

class Tag extends AbstractEntity
{
    /**
     * @var string The name of the product
     */
    protected string $_name;

    /**
     * @var string The description of the product
     */
    protected string $_description;

    /**
     * Get the value of _name
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * Set the value of _name
     */
    public function setName(string $name): self
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get the value of _description
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * Set the value of _description
     */
    public function setDescription(string $description): self
    {
        $this->_description = $description;

        return $this;
    }
}