<?php


class ProductEntity
{
	private int $id;
	private string $name;
	private int $tome_number;
	private int $quantity;
	private string $image_link;
	private string $description;
	private float $price;
	private int $nbSells;
	private int $type;
	

	/**
	 * ProductEntity constructor.
	 * @param int $id
	 * @param string $name
	 * @param int $tome_number
	 * @param int $quantity
	 * @param string $image_link
	 * @param string $description
	 * @param float $price
	 * @param int $nbSells
	 */

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getTomeNumber(): int
	{
		return $this->tome_number;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @return string
	 */
	public function getImageLink(): string
	{
		return $this->image_link;
	}

	/**
	 * @return int
	 */
	public function getDescription(): string
	{
		return $this->description;
	}
	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}
	public function getSells(): int
	{
		return $this->nbSells;
	}
	public function getType(): int
	{
		return $this->type;
	}



	/**
	 * @param int $id
	 */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @param string $tome_number
	 */
	public function setTomeNumber(string $tome_number): void
	{
		$this->tome_number = $tome_number;
	}

	/**
	 * @param int $quantity
	 */
	public function setQuantity(int $quantity): void
	{
		$this->quantity = $quantity;
	}

	/**
	 * @param int $image_link
	 */
	public function setImageLink(int $image_link): void
	{
		$this->image_link = $image_link;
	}

	/**
	 * @param int $description
	 */
	public function setDescription(int $description): void
	{
		$this->description = $description;
	}

	/**
	 * @param float $price
	 */
	public function setPrice(float $price): void
	{
		$this->price = $price;
	}

	/**
	 * @param int $id
	 */
	public function setSells(int $sells): void
	{
		$this->nbSells = $sells;
	}
	
	/**
	 * @param int $id
	 */
	public function setType(int $type): void
	{
		$this->type = $type;
	}




}
