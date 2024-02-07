<?php

class AdminEntity
{

    private string $id;
    private string $login;
    private string $hashed_password;
    private int $active;

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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $last_name
     */
    public function setLogin($login): void
    {
        $this->login = $login;
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
}