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
     * @var string The category name retrieved using $_category_id foreign key property
     */
    private string $_category_name;

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
     * Get the value of _slug
     */
    public function getSlug(): string
    {
        return $this->_slug;
    }

    /**
     * Set the value of _slug
     */
    public function setSlug(string $slug): self
    {
        $this->_slug = $slug;

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
    public function setPrice(int $price): self
    {
        $this->_price = $price;

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
    public function setImage(string $image): self
    {
        $this->_image = $image;

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
    public function setQuantitySold(int $quantity_sold): self
    {
        $this->_quantity_sold = $quantity_sold;

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
    public function setCreatedAt(DateTime $created_at): self
    {
        $this->_created_at = $created_at;

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
    public function setUpdatedAt(?DateTime $updated_at): self
    {
        $this->_updated_at = $updated_at;

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
    public function setDeletedAt(?DateTime $deleted_at): self
    {
        $this->_deleted_at = $deleted_at;

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
    public function setCategoryId(int $category_id): self
    {
        $this->_category_id = $category_id;

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
    public function setDiscountId(?int $discount_id): self
    {
        $this->_discount_id = $discount_id;

        return $this;
    }

    /**
     * Get the value of _category_name
     */
    public function getCategoryName(): string
    {
        return $this->_category_name;
    }

    /**
     * Set the value of _category_name
     */
    public function setCategoryName(string $category_name): self
    {
        $this->_category_name = $category_name;

        return $this;
    }
}