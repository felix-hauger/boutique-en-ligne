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

    /**
     * Hydrate child entities
     * @param array $data Retrieved associative array containing fetched data
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key))) ;
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}