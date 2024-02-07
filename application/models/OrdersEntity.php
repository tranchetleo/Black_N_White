<?php

class OrdersEntity
{

    private int $user_id;
    private int $product_id;
    private int $quantity;
    private string $date;

    /**
     * @return false|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param false|string|null $first_name
     */
    public function setid($id): void
    {
        $this->id = $id;
    }

    /**
     * @return false|string|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param false|string|null $first_name
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return false|string|null
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param false|string|null $last_name
     */
    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $id
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity >= 0) {
            $this->quantity = $quantity;
        } else {
            $this->quantity = 0;
        }
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $id
     */
    public function setDate(int $date): void
    {
        $this->date = $date;
    }

}