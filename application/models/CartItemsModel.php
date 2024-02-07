<?php

require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsEntity.php";
require APPPATH."..".DIRECTORY_SEPARATOR."system".DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."Model.php";
class CartItemsModel extends CI_Model {

	private function __construct() {
		// Le constructeur est privé pour empêcher l'instanciation directe de la classe
		parent::__construct();
	}
    private function __clone() {}
	private static $instance = null;

	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new CartItemsModel();
        }
        return self::$instance;
    }

    public function findAll($user_id){
		$this->load->model('ProductModel');
		$this->db->select('*');
		$q = $this->db->query("SELECT * FROM `Products`, `CartItems` WHERE (`CartItems`.`user_id` = '$user_id') AND (`Products`.`id` = `CartItems`.`product_id`)");
		$response = $q-> custom_result_object("ProductEntity");
		return $response;
    }

	public function removeProduct(ProductEntity $product, UserEntity $user):bool{
		$product_id = $product->getId();
		$user_id = $user->getId();
		$this->db->query("DELETE FROM `CartItems` WHERE `CartItems`.`user_id` = $user_id AND `CartItems`.`product_id` = $product_id");
		if ($this->db->affected_rows()==1){
			return true;
		}
		return false;
	}

	public function removeAll(UserEntity $user){
		$user_id = $user->getId();
		$this->db->query("DELETE FROM `CartItems` WHERE `CartItems`.`user_id` = $user_id");
		if ($this->db->affected_rows()!=0){
			return true;
		}
		return false;
	}

    public function findByLogin(string $login)
    {
		$this->db->select('*');
		$q = $this->db->get_where('Users',array('email'=>$login));
		$response = $q->row(0,"UserEntity");
		return $response;
    }

	public function getCartQuantity(Int $product_id, Int $user_id){
		$q = $this->db->query("SELECT * FROM `CartItems` WHERE (`CartItems`.`user_id` = '$user_id') AND (`CartItems`.`product_id` = '$product_id')");
		$response = $q->custom_result_object("CartItemsEntity");
		$cart = $response[0];
		$quantity = $cart->getQuantity();

		return $quantity;
	}

	public function getProductQuantity(ProductEntity $product){
		return $product->getQuantity();
	}

	public function reduceQuantity(ProductEntity $product, UserEntity $user){
		$product_id = $product->getId();
		$user_id = $user->getId();

		$quantity = $this->getCartQuantity($product_id, $user_id);

		if ($quantity-1 == 0){
			$this->db->query("DELETE FROM `CartItems` WHERE `CartItems`.`user_id` = $user_id AND `CartItems`.`product_id` = $product_id");
		} else {
			$this->db->query("UPDATE `CartItems` SET `quantity` = $quantity-1 WHERE (`user_id` = $user_id AND `product_id` = $product_id)");
		}
	}

	public function increaseQuantity(ProductEntity $product, UserEntity $user){
		$product_id = $product->getId();
		$user_id = $user->getId();

		$quantity = $this->getCartQuantity($product_id, $user_id);
		$productQuantity = $product->getQuantity();

		if ($quantity+1 > $productQuantity){
			if ($productQuantity == 0){
				$this->db->query("DELETE FROM `CartItems` WHERE `CartItems`.`user_id` = $user_id AND `CartItems`.`product_id` = $product_id");
			}else{
				$this->db->query("UPDATE `CartItems` SET `quantity` = $productQuantity WHERE (`user_id` = $user_id AND `product_id` = $product_id)");
			}
		} else {
			$this->db->query("UPDATE `CartItems` SET `quantity` = $quantity+1 WHERE (`user_id` = $user_id AND `product_id` = $product_id)");
		}
	}
	

}
?>
