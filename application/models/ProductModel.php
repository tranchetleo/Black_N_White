<?php
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."ProductEntity.php";
class ProductModel extends CI_Model {

     function findAll(){
	    $this->db->select('*');
	    $q = $this->db->get('Products');
		$response = $q-> custom_result_object("ProductEntity");
	    return $response;
	}

	function findById($id){
	    $q = $this->db->get_where('Products',array('id'=>$id));
	    $response = $q->custom_result_object("ProductEntity");
	    return $response;
	}

	function findByName($name){
		$this->db->select('*');
		$q = $this->db->get_where('Products',array('name'=>$name));
		$response = $q->custom_result_object("ProductEntity");
		$response = array_slice($response, 0, 5);
		return $response;
	}

	function findLatests(){
	    $q = $this->db->get('Products');
		$response = $q-> custom_result_object("ProductEntity");
		$response = array_reverse($response);
		$latest = array_slice($response, 0, 10);
		return $latest;
	}

	function comparator($a, $b){
		if ($a->getSells()==$b->getSells()){
			return 0;
		}
	return ($a->getSells()<$b->getSells())?-1:1;
	}

	function findBigThree(){
		$array = $this->findAll();
		usort($array, function ($a, $b)
		{
			if ($a->getSells()==$b->getSells()){
				return 0;
			}
		return ($a->getSells()>$b->getSells())?-1:1;
		});
		$array = array_slice($array, 0, 3);
		return $array;
	}

	function delete(int $id): bool {
		$this->db->delete('product', array('id' => $id));
		return $this->db->affected_rows()!=0;
	}

	function add(ProductEntity $product):?ProductEntity{
		$id = $product->getId();
		$name = $product->getName();
		$price = $product->getPrice();
		$quantity = $product->getQuantity();
     	$data = array(
			'id' => $id,
			'name' => $name,
			'tome_number' => $tome_number,
			'quantity' => $quantity,
			'image_link' => $image_link,
			'description'=> $description,
			'price' => $price
		);
     	try {
			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->insert('product', $data);
			$this->db->db_debug = $db_debug;
		} catch (Exception $e) {}
		return $this->findById($id);
	}

	function findByKeyWords(array $listKW, string $tri, string $filtres){
		$string = "Products WHERE ((`name` LIKE ('%".$listKW[0]."%')) OR (`tome_number` LIKE ('%".$listKW[0]."%') OR `image_link` LIKE ('%".$listKW[0]."%')))";
		foreach($listKW as $kw){
			$string .= "AND (`name` LIKE ('%".$kw."%') OR `tome_number` LIKE ('%".$kw."%') OR `image_link` LIKE ('%".$kw."%'))";
		}
		$string .= $filtres;
		$string .= $tri;
		$q = $this->db->get($string);
		$response = $q->custom_result_object("ProductEntity");
	    return $response;
	}

	public function update(int $idS, ProductEntity $product): ProductEntity{
		$id = $product->getId();
		$name = $product->getName();
		$price = $product->getPrice();
		$quantity = $product->getQuantity();
		$data = array(
			'id' => $id,
			'name' => $name,
			'tome_number' => $tome_number,
			'quantity' => $quantity,
			'image_link' => $image_link,
			'description'=> $description,
			'price' => $price
		);
		try {
			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->set($data);
			$this->db->where('id',$id);
			$this->db->update('product');
			$this->db->db_debug = $db_debug;
		} catch (Exception $e) {}
		return $this->findById($id);
	}
	
	public function addProductToCart(ProductEntity $product, UserEntity $user):bool{
		$product_id = $product->getId();
		$user_id = $user->getId();

		$this->db->select('*');
	    $q = $this->db->get_where('CartItems',array('user_id'=>$user_id, 'product_id'=>$product_id));

		if ($this->db->affected_rows()!=1){
			$this->db->query("INSERT INTO `CartItems` (`user_id`, `product_id`, `quantity`) VALUES ($user_id, $product_id, 1)");
			if ($this->db->affected_rows()==1){
				return true;
			}
		}
		return false;
	}
 }
 ?>
