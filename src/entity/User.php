<?php

namespace App\Entity;

class User
{
    /**
     * @var int identifies entity
     */
    private int $_id;

    /**
     * @var string login to auth
     */
    private string $_login;

    /**
     * @var string password to auth, do not store in session
     */
    private string $_password;

    /**
     * @var string email
     */
    private string $_email;

    /**
     * @var string username visible to other users
     */
    private string $_username;

    /**
     * @var string personal info
     */
    private string $_firstname;

    /**
     * @var string personal info
     */
    private string $_lastname;

    /**
     * @var int represent the foreign key role id
     * role determine what the user can & cannot do
     */
    private int $_role_id;

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
