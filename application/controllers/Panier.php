<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Panier extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){	
		// Chargement du modèle de données
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
		$this->load->view('Panier', $data);
	}

	public function addToCart(int $id){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('ProductModel');
		
		// Si l'utilisateur est connecté, on récupère le produit et l'utilisateur en question
		if (isset($_SESSION['email'])){
			$this->load->model('UserModel');
			$product = $this->ProductModel->findById($id)[0];
			$user = $this->UserModel->findByLogin($_SESSION['email']);
			
			// On ajoute le produit au panier de l'utilisateur
			$res = $this->ProductModel->addProductToCart($product, $user);
		}
		
		// Redirection vers la page du panier
		redirect('Panier');
	}

	public function removeAllFromCart(){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('UserModel');

		// Suppression de tous les articles du panier de l'utilisateur
		if (isset($_SESSION['email'])){
			$user = $this->UserModel->findByLogin($_SESSION['email']);
			$res = $cartItemsModel->removeAll($user);	
		}

		// Redirection vers la page du panier
		redirect('Panier');
	}
	
	public function removeFromCart(int $id){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('ProductModel');
		$this->load->model('UserModel');

		// Récupération du produit et de l'utilisateur
		$product = $this->ProductModel->findById($id)[0];
		$user = $this->UserModel->findByLogin($_SESSION['email']);
		
		// Suppression du produit du panier de l'utilisateur
		$res = $cartItemsModel->removeProduct($product, $user);

		// Redirection vers la page du panier
		redirect('Panier');
	}

	public function reduceQuantity(int $productId){
		// Chargement des modèles de données
		$this->load->model('ProductModel');
		$this->load->model('UserModel');
		$cartItemsModel = CartItemsModel::getInstance();
		
		// Récupération du produit et de l'utilisateur actuel
		$product = $this->ProductModel->findById($productId)[0];
		$user = $this->UserModel->findByLogin($_SESSION['email']);
		
		// Réduction de la quantité de l'article dans le panier
		$res = $cartItemsModel->reduceQuantity($product, $user);
		
		// Redirection vers le panier
		redirect('Panier');
	}

	public function increaseQuantity(int $productId){
		// Chargement des modèles de données nécessaires
		$this->load->model('ProductModel');
		$this->load->model('UserModel');
		$cartItemsModel = CartItemsModel::getInstance();
	
		// Récupération du produit et de l'utilisateur actuellement connecté
		$product = $this->ProductModel->findById($productId)[0];
		$user = $this->UserModel->findByLogin($_SESSION['email']);
	
		// Augmentation de la quantité du produit dans le panier de l'utilisateur
		$res = $cartItemsModel->increaseQuantity($product, $user);
	
		// Redirection vers la page du panier
		redirect('Panier');
	}


	public function checkCartToPay(){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('ProductModel');
		$this->load->model('OrdersModel');
	
		// Si l'utilisateur est connecté
		if (isset($_SESSION['user_id'])){
			// Récupération de l'ID de l'utilisateur et du contenu du panier
			$userId = $_SESSION['user_id'];
			$products = $cartItemsModel->findAll($userId);
			$erreur = false;
			
			// Si le panier n'est pas vide
			if(isset($products[0])){
				foreach ($products as $product){
					// Récupération de la quantité du produit dans le panier et de la quantité restante du produit en stock
					$cartQuantity = $cartItemsModel->getCartQuantity($product->getId(), $userId);
					$productQuantity = $this->ProductModel->findById($product->getId())[0]->getQuantity();;
					
					// Si la quantité du produit dans le panier est supérieure à la quantité restante en stock
					if ($cartQuantity > $productQuantity){
						// Initialisation d'une variable de session indiquant une erreur
						$_SESSION['erreurPanier'] = "1";
						
						// La fonction increase permettra de mettre la quantité dans le panier à la plus haute quantité possible(celle en stock)
						$this->increaseQuantity($product->getId());
						$erreur = true;
					}
				}
				// Si aucune erreur n'a été détectée
				if($erreur != true){
					foreach($products as $product){
						$cartQuantity = $cartItemsModel->getCartQuantity($product->getId(), $userId);
						$this->OrdersModel->addOrder($userId, $product->getId(), $cartQuantity);
					}
					// Redirection vers la page de paiement
					redirect('Paiement');
				}
			}
			// Si le panier est vide, redirection vers la page du panier
			redirect('Panier');
		}
		// Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
		redirect('Connexion');
	}
}



