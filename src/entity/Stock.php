<?php

namespace App\Entity;

class Stock
{
    /**
     * @var int Identifies entity
     */
    private int $_id;

    /**
     * @var int The number of items in xs size
     */
    private int $_xs;

    /**
     * @var int The number of items in s size
     */
    private int $_s;

    /**
     * @var int The number of items in m size
     */
    private int $_m;

    /**
     * @var int The number of items in l size
     */
    private int $_l;

    /**
     * @var int The number of items in xl size
     */
    private int $_xl;

    /**
     * @var int The number of items in xxl size
     */
    private int $_xxl;

    /**
     * @var int Identifies product
     */
    private int $_product_id;

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

        return $this;
    }

    /**
     * Get the value of xs
     */
    public function getXs(): int
    {
        return $this->_xs;
    }

    /**
     * Set the value of xs
     */
    public function setXs(int $xs): self
    {
        $this->_xs = $xs;

        return $this;
    }

    /**
     * Get the value of s
     */
    public function getS(): int
    {
        return $this->_s;
    }

    /**
     * Set the value of s
     */
    public function setS(int $s): self
    {
        $this->_s = $s;

        return $this;
    }

    /**
     * Get the value of m
     */
    public function getM(): int
    {
        return $this->_m;
    }

    /**
     * Set the value of m
     */
    public function setM(int $m): self
    {
        $this->_m = $m;

        return $this;
    }

    /**
     * Get the value of l
     */
    public function getL(): int
    {
        return $this->_l;
    }

    /**
     * Set the value of l
     */
    public function setL(int $l): self
    {
        $this->_l = $l;

        return $this;
    }

    /**
     * Get the value of xl
     */
    public function getXl(): int
    {
        return $this->_xl;
    }

    /**
     * Set the value of xl
     */
    public function setXl(int $xl): self
    {
        $this->_xl = $xl;

        return $this;
    }

    /**
     * Get the value of xxl
     */
    public function getXxl(): int
    {
        return $this->_xxl;
    }

    /**
     * Set the value of xxl
     */
    public function setXxl(int $xxl): self
    {
        $this->_xxl = $xxl;

        return $this;
    }

    /**
     * Get the value of product_id
     */
    public function getProductId(): int
    {
        return $this->_product_id;
    }

    /**
     * Set the value of product_id
     */
    public function setProductId(int $product_id): self
    {
        $this->_product_id = $product_id;

        return $this;
    }
}