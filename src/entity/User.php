<?php

namespace App\Entity;

class User extends AbstractEntity
{
    /**
     * @var int Identifies entity
     */
    protected int $_id;

    /**
     * @var string Login to auth
     */
    protected string $_login;

    /**
     * @var string Password to auth, do not store in session
     */
    protected string $_password;

    /**
     * @var string Email
     */
    protected string $_email;

    /**
     * @var string Username visible to other users
     */
    protected string $_username;

    /**
     * @var string Personal info
     */
    protected string $_firstname;

    /**
     * @var string Personal info
     */
    protected string $_lastname;

    /**
     * @var int Represents the foreign key role_id
     *          Role determine what the user can & cannot do
     */
    protected int $_role_id;

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
     * Get the value of login
     */
    public function getLogin(): string
    {
        return $this->_login;
    }

    /**
     * Set the value of login
     */
    public function setLogin(string $login): self
    {
        $this->_login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(string $username): self
    {
        $this->_username = $username;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname(): string
    {
        return $this->_firstname;
    }

    /**
     * Set the value of firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->_firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname(): string
    {
        return $this->_lastname;
    }

    /**
     * Set the value of lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->_lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role_id
     */
    public function getRoleId(): int
    {
        return $this->_role_id;
    }

    /**
     * Set the value of role_id
     */
    public function setRoleId(int $role_id): self
    {
        $this->_role_id = $role_id;

        return $this;
    }
}
