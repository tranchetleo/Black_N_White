<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Recherche extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){	
		// Chargement de la vue de recherche
		$this->load->view('Recherche');
	}

	public function search(){
		header('Cache-Control: no cache');

		//Chargement des modèles de données
		$this->load->model('ProductModel');
		$cartItemsModel = CartItemsModel::getInstance();

		// Récupération du contenu du panier
		if (isset($_SESSION['email'])){
			$cart = $cartItemsModel->findAll($_SESSION['user_id']);
		} else {
			$vide = "";
			$cart = $cartItemsModel->findAll($vide);
		}

		// Initialisation des variables de tri et de filtres
		$tri = "ORDER BY `id` DESC;";
		$filtres = "";

		// Mise à jour des variables de tri et de filtres si nécessaire
		if (isset($_POST['radio'])){
			$triCase = $_POST['radio'];
			if ($triCase == 1){
				$tri = "ORDER BY `nbSells` DESC;";
			}
			if ($triCase == 2){
				$tri = "ORDER BY `name` ASC;";
			}
			if ($triCase == 3){
				$tri = "ORDER BY `name` DESC;";
			}
			if ($triCase == 4){
				$tri = "ORDER BY `price` ASC;";
			}
			if ($triCase == 5){
				$tri = "ORDER BY `price` DESC;";
			}
		}

		if (isset($_POST['bookMark'])){
			$filtres .= " AND `type` = 2 ";
		}
		if (isset($_POST['aviable'])){
			$filtres .= " AND `quantity` > 0 ";
		}

		// Récupération et traitement des mots-clés de la recherche
		$key_words = $this->input->post('search');
		$key_words = str_replace("'"," ", $key_words);
		$list_inputs = explode(" ", $key_words);
		$_SESSION['lastSearch'] = $key_words;

		// Recherche des produits
		$products = $this->ProductModel->findByKeyWords($list_inputs, $tri, $filtres);

				// Chargement de la vue avec comme paramètre les articles correspondants à la recherche
		$data = array("prods"=>$products, "cartItems"=>$cart);
		$this->load->view('Recherche', $data);
	}
}



