<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class PageProduit extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){	
		// Chargement du modèle de données des articles du panier
		$cartItemsModel = CartItemsModel::getInstance();
		
		// Récupération du contenu du panier
		if (isset($_SESSION['email'])){
			$products = $cartItemsModel->findAll($_SESSION['user_id']);
		} else {
			$vide = "";
			$products = $cartItemsModel->findAll($vide);
		}
		
		// Chargement de la vue avec comme paramètre les articles du panier
		$data = array("cartItems"=>$products);
		$this->load->view('PageProduit', $data);
	}

	public function produit(int $id){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('ProductModel');
		
		// Récupération du contenu du panier
		if (isset($_SESSION['email'])){
			$cart = $cartItemsModel->findAll($_SESSION['user_id']);
		} else {
			$vide = "";
			$cart = $cartItemsModel->findAll($vide);
		}
		
		// Récupération des derniers produits ajoutés, le produit spécifique et les autres produits ayant le même nom
		$products = $this->ProductModel->findLatests();
		$itemArray = $this->ProductModel->findById($id);
		$otherVolumes = $this->ProductModel->findByName($itemArray[0]->getName());
		
		// Chargement de la vue avec comme parametre les tableaux qu'on vient de créer
		$data = array("prods"=>$products, "items"=>$itemArray, "cartItems"=>$cart, "volumes"=>$otherVolumes);
		$this->load->view('PageProduit',$data);
		
	}
}



