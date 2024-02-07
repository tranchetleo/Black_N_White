<?php
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."OrdersEntity.php";
class OrdersModel extends CI_Model {

    function findAll(){
	    $this->db->select('*');
	    $q = $this->db->get('Orders');
		$response = $q-> custom_result_object("OrdersEntity");
	    return $response;
	}

	function find($user_id, $product_id, $date){
	    $q = $this->db->get_where('Orders',array('user_id'=>$user_id, 'product_id'=>$product_id, 'date'=>$date));
	    $response = $q->custom_result_object("OrdersEntity");
	    return $response;
	}

	function findByID($id){
	    $q = $this->db->get_where('Orders',array('id'=>$id));
	    $response = $q->custom_result_object("OrdersEntity");
	    return $response;
	}

	public function addOrder(Int $user_id, Int $product_id, Int $quantity):bool{
		$date = date('Y-m-d H:i:s');

		// Exécuter la requête d'insertion et vérifier si l'opération a réussi
		$this->db->query("INSERT INTO `Orders` (`user_id`, `product_id`, `quantity`, `date`) VALUES ('$user_id', '$product_id', '$quantity', '$date')");
		if ($this->db->affected_rows()==1){
			// Mise à jour des stocks en base de données
			$currentQuantity = $this->db->query("SELECT `quantity` FROM `Products` WHERE `id` = '$product_id'")->row()->quantity;
			$newQuantity = $currentQuantity - $quantity;
			$this->db->query("UPDATE `Products` SET `quantity` = '$newQuantity' WHERE `id` = $product_id");

			// Récupérer l'ID de la commande inséré afin de le stoquer en session pour eventuelle annulation de commande
			$Id = $this->find($user_id, $product_id, $date)[0]->getId();
			if(isset($_SESSION['Orders'])){
				array_push($_SESSION['Orders'], $Id);
			} else {
				$_SESSION['Orders'] = array($Id);
			}
			return true;
		} else {
			return false;
		}
	}
	
	public function removeOrder(Int $id){
		if (isset($this->findByID($id)[0])){
			$order = $this->findByID($id)[0];
			$quantity = $order->getQuantity();
			$product_id = $order->getProductId();
			
			// Exécuter la requête d'insertion et vérifier si l'opération a réussi
			$this->db->query("DELETE FROM `Orders` WHERE `id` = '$id'");
			if ($this->db->affected_rows()==1){
				// Mise à jour des stocks en base de données
				$currentQuantity = $this->db->query("SELECT `quantity` FROM `Products` WHERE `id` = '$product_id'")->row()->quantity;
				$newQuantity = $currentQuantity + $quantity;
				$this->db->query("UPDATE `Products` SET `quantity` = '$newQuantity' WHERE `id` = $product_id");
	
				return true;
			}
		} else {
			return false;
		}
	}

}
?>
