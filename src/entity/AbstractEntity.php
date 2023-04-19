<?php

namespace App\Entity;

abstract class AbstractEntity
{
    /**
     * @var int identifies entity
     */
    protected int $_id;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->_id = $id;

    // ! in vscode $this represents AbstractEntity even in child classes
        return $this; 
    }

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
}
