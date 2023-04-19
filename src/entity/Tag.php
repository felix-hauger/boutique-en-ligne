<?php

namespace App\Entity;

class Tag
{
    /**
     * @var int Identifies entity
     */
    private int $_id;

    /**
     * @var string The name of the product
     */
    private string $_name;

    /**
     * @var string The description of the product
     */
    private string $_description;

    /**
     * format properties names using field names from database
     * properties names must start by an underscore "_"
     */
    public function __set($name, $value)
    {
        if ($name[0] !== '_') {
            $this->{'_' . $name} = $value;
        }
    }

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
    public function setId(int $id): self
    {
        $this->_id = $id;

        return $this;
    }

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
