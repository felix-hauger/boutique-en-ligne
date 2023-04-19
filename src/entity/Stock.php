<?php

namespace App\Entity;

class Stock extends AbstractEntity
{
    /**
     * @var int The number of items in xs size
     */
    protected int $_xs;

    /**
     * @var int The number of items in s size
     */
    protected int $_s;

    /**
     * @var int The number of items in m size
     */
    protected int $_m;

    /**
     * @var int The number of items in l size
     */
    protected int $_l;

    /**
     * @var int The number of items in xl size
     */
    protected int $_xl;

    /**
     * @var int The number of items in xxl size
     */
    protected int $_xxl;

    /**
     * @var int Identifies product
     */
    protected int $_product_id;

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