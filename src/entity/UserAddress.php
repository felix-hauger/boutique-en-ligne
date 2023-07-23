<?php

namespace App\Entity;

class UserAddress extends AbstractEntity
{
    /**
     * @var string The address alias (home, work...)
     */
    private string $_alias;

    /**
     * @var string The first line of the address
     */
    private string $_address_line1;

    /**
     * @var ?string The second line of the address, optional
     */
    private ?string $_address_line2;

    /**
     * @var string The city
     */
    private string $_city;

    /**
     * @var string The postal code of the address
     */
    private string $_postal_code;

    /**
     * @var string The country
     */
    private string $_country;

    /**
     * @var string The user phone number
     */
    private string $_phone;

    /**
     * @var ?string The user mobile phone number
     */
    private ?string $_mobile;

    /**
     * @var string The user id, foreign key
     */
    private int $_user_id;

    /**
     * Get the value of _alias
     */
    public function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * Set the value of _alias
     */
    public function setAlias(string $_alias): self
    {
        $this->_alias = $_alias;

        return $this;
    }

    /**
     * Get the value of _address_line1
     */
    public function getAddressLine1(): string
    {
        return $this->_address_line1;
    }

    /**
     * Set the value of _address_line1
     */
    public function setAddressLine1(string $_address_line1): self
    {
        $this->_address_line1 = $_address_line1;

        return $this;
    }

    /**
     * Get the value of _address_line2
     */
    public function getAddressLine2(): ?string
    {
        return $this->_address_line2;
    }

    /**
     * Set the value of _address_line2
     */
    public function setAddressLine2(?string $_address_line2): self
    {
        $this->_address_line2 = $_address_line2;

        return $this;
    }

    /**
     * Get the value of _city
     */
    public function getCity(): string
    {
        return $this->_city;
    }

    /**
     * Set the value of _city
     */
    public function setCity(string $_city): self
    {
        $this->_city = $_city;

        return $this;
    }

    /**
     * Get the value of _postal_code
     */
    public function getPostalCode(): string
    {
        return $this->_postal_code;
    }

    /**
     * Set the value of _postal_code
     */
    public function setPostalCode(string $_postal_code): self
    {
        $this->_postal_code = $_postal_code;

        return $this;
    }

    /**
     * Get the value of _country
     */
    public function getCountry(): string
    {
        return $this->_country;
    }

    /**
     * Set the value of _country
     */
    public function setCountry(string $_country): self
    {
        $this->_country = $_country;

        return $this;
    }

    /**
     * Get the value of _phone
     */
    public function getPhone(): string
    {
        return $this->_phone;
    }

    /**
     * Set the value of _phone
     */
    public function setPhone(string $_phone): self
    {
        $this->_phone = $_phone;

        return $this;
    }

    /**
     * Get the value of _mobile
     */
    public function getMobile(): ?string
    {
        return $this->_mobile;
    }

    /**
     * Set the value of _mobile
     */
    public function setMobile(?string $_mobile): self
    {
        $this->_mobile = $_mobile;

        return $this;
    }

    /**
     * Get the value of _user_id
     */
    public function getUserId(): int
    {
        return $this->_user_id;
    }

    /**
     * Set the value of _user_id
     */
    public function setUserId(int $_user_id): self
    {
        $this->_user_id = $_user_id;

        return $this;
    }
}