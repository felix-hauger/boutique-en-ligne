<?php

namespace App\Entity;

use DateTime;

class Product extends AbstractEntity
{
    /**
     * @var int Identifies entity
     */
    protected int $_id;

    /**
     * @var string The name of the product
     */
    protected string $_name;

    /**
     * @var string The slug of the product to create URI
     */
    protected ?string $_slug = null;

    /**
     * @var string The description of the product
     */
    protected ?string $_description = null;

    /**
     * @var int The price of the product in the smallest monetary unity
     */
    protected int $_price;

    /**
     * @var string The path leading to product image
     */
    protected string $_image;

    /**
     * @var int The total sold quantity of a product
     */
    protected int $_quantity_sold;

    /**
     * @var Datetime The insertion date of the product in the database 
     */
    protected DateTime $_created_at;

    /**
     * @var ?Datetime The latest date when the product was updated
     */
    protected ?DateTime $_updated_at = null;

    /**
     * @var ?Datetime The deletion date to make product unavalaible for purchase 
     * but preserve it in database for admin & customer purchase history
     */
    protected ?DateTime $_deleted_at = null;

    /**
     * @var int representing the foreign key category_id 
     */
    protected int $_category_id;

    /**
     * @var int representing the foreign key discount_id 
     */
    protected ?int $_discount_id = null;

    /**
     * @var string The category name retrieved using $_category_id foreign key property
     */
    protected string $_category_name;

    /**
     * @var string Description excerpt
     */
    protected string $_preview;

    /**
     * @var array Store product tags
     */
    protected array $_tags;

    /**
     * @var ?Stock Entity storing product stock by size with its properties
     */
    protected ?Stock $_stock;

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
    public function getSlug(): ?string
    {
        return $this->_slug;
    }

    /**
     * Set the value of _slug
     */
    public function setSlug(?string $slug): self
    {
        $this->_slug = $slug;

        return $this;
    }

    /**
     * Get the value of _description
     */
    public function getDescription(): ?string
    {
        return $this->_description;
    }

    /**
     * Set the value of _description
     */
    public function setDescription(?string $description): self
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

    /**
     * Get the value of _tags
     */
    public function getTags(): array
    {
        return $this->_tags;
    }

    /**
     * Set the value of _tags
     */
    public function setTags(array $tags): self
    {
        $this->_tags = $tags;

        return $this;
    }

    /**
     * Get the value of _stock
     */
    public function getStock(): ?Stock
    {
        return $this->_stock;
    }

    /**
     * Set the value of _stock
     */
    public function setStock(?Stock $_stock): self
    {
        $this->_stock = $_stock;

        return $this;
    }

    /**
     * Get the value of _preview
     */
    public function getPreview(): string
    {
        return $this->_preview;
    }

    /**
     * Set the value of _preview
     */
    public function setPreview(string $_preview): self
    {
        $this->_preview = $_preview;

        return $this;
    }
}
