<?php

class CartItemsEntity
{

    private int $user_id;
    private int $product_id;
    private int $quantity;


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

}