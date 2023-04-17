<?php

namespace App\Entity;

use DateTime;

class Product
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
     * @var string The slug of the product to create URI
     */
    private string $_slug;
    
    /**
     * @var string The description of the product
     */
    private string $_description;
    
    /**
     * @var int The price of the product in the smallest monetary unity
     */
    private int $_price;
    
    /**
     * @var string The path leading to product image
     */
    private string $_image;
    
    /**
     * @var int The total sold quantity of a product
     */
    private int $_quantity_sold;
    
    /**
     * @var Datetime The insertion date of the product in the database 
     */
    private DateTime $_created_at;
    
    /**
     * @var ?Datetime The latest date when the product was updated
     */
    private ?DateTime $_updated_at = null;
    
    /**
     * @var ?Datetime The deletion date to make product unavalaible for purchase 
     * but preserve it in database for admin & customer purchase history
     */
    private ?DateTime $_deleted_at = null;
    
    /**
     * @var int representing the foreign key category_id 
     */
    private int $_category_id;
    
    /**
     * @var int representing the foreign key discount_id 
     */
    private ?int $_discount_id = null;

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
     * Get the value of _name
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * Set the value of _name
     */
    public function setName(string $_name): self
    {
        $this->_name = $_name;

        return $this;
    }

    /**
     * Get the value of _slug
     */
    public function getSlug(): string
    {
        return $this->_slug;
    }

    /**
     * Set the value of _slug
     */
    public function setSlug(string $_slug): self
    {
        $this->_slug = $_slug;

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
    public function setDescription(string $_description): self
    {
        $this->_description = $_description;

        return $this;
    }

    /**
     * Get the value of _price
     */
    public function getPrice(): int
    {
        return $this->_price;
    }

    /**
     * Set the value of _price
     */
    public function setPrice(int $_price): self
    {
        $this->_price = $_price;

        return $this;
    }

    /**
     * Get the value of _image
     */
    public function getImage(): string
    {
        return $this->_image;
    }

    /**
     * Set the value of _image
     */
    public function setImage(string $_image): self
    {
        $this->_image = $_image;

        return $this;
    }

    /**
     * Get the value of _quantity_sold
     */
    public function getQuantitySold(): int
    {
        return $this->_quantity_sold;
    }

    /**
     * Set the value of _quantity_sold
     */
    public function setQuantitySold(int $_quantity_sold): self
    {
        $this->_quantity_sold = $_quantity_sold;

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
    public function getUpdatedAt(): ?DateTime
    {
        return $this->_updated_at;
    }

    /**
     * Set the value of _updated_at
     */
    public function setUpdatedAt(?DateTime $_updated_at): self
    {
        $this->_updated_at = $_updated_at;

        return $this;
    }

    /**
     * Get the value of _deleted_at
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->_deleted_at;
    }

    /**
     * Set the value of _deleted_at
     */
    public function setDeletedAt(?DateTime $_deleted_at): self
    {
        $this->_deleted_at = $_deleted_at;

        return $this;
    }

    /**
     * Get the value of _category_id
     */
    public function getCategoryId(): int
    {
        return $this->_category_id;
    }

    /**
     * Set the value of _category_id
     */
    public function setCategoryId(int $_category_id): self
    {
        $this->_category_id = $_category_id;

        return $this;
    }

    /**
     * Get the value of _discount_id
     */
    public function getDiscountId(): ?int
    {
        return $this->_discount_id;
    }

    /**
     * Set the value of _discount_id
     */
    public function setDiscountId(?int $_discount_id): self
    {
        $this->_discount_id = $_discount_id;

        return $this;
    }
}