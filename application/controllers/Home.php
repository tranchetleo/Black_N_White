<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Home extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){
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

		// Récupération des derniers produits ajoutés et des trois produits les plus populaires
		$products = $this->ProductModel->findLatests();
		$top = $this->ProductModel->findBigThree();

		// Chargement de la vue avec comme parametre les tableaux qu'on vient de créer
		$data = array("prods"=>$products, "best"=>$top, "cartItems"=>$cart);
		$this->load->view('index', $data);
	}
}



