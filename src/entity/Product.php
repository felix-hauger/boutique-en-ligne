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
     * @var Datetime The latest date when the product was updated
     */
    private DateTime $_updated_at;
    
    /**
     * @var Datetime The deletion date to make product unavalaible for purchase 
     * but preserve it in database for admin & customer purchase history
     */
    private DateTime $_deleted_at;
    
    /**
     * @var int representing the foreign key category_id 
     */
    private int $_category_id;
    
    /**
     * @var int representing the foreign key discount_id 
     */
    private int $_discount_id;
}