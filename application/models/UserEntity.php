<?php

class UserEntity
{

    private string $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $hashed_password;
    private string $confirmation_code;
    private int $active;

    public function isValidfirst_name(string $first_name):bool {
        return first_name_verify($first_name, $this->first_name);
    }

    public function isEmail(string $email):bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public function isValidEmail(string $email):bool {
        return email_verify($email, $this->email);
    }
    
    public function isValidPswd(string $password):bool {
        return password_verify($password, $this->password);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return false|string|null
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param false|string|null $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return false|string|null
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param false|string|null $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return false|string|null
     */
    public function getHashedPassword()
    {
        return $this->hashed_password;
    }

    /**
     * @param false|string|null $last_name
     */
    public function setHashedPassword($hashed_password): void
    {
        $this->last_name = $hashed_password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $last_name
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

        /**
     * @return string
     */
    public function getConfirmarionCode()
    {
        return $this->confirmation_code;
    }

    /**
     * @param string $last_name
     */
    public function setConfirmarionCode($confirmation_code): void
    {
        $this->confirmation_code = $confirmation_code;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $id
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function isActive(): int
    {
        return $this->active == 1;
    }



    /**
     * @param false|string|null $first_name
     */
    public function setEncryptedFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }
}