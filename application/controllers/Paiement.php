<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Paiement extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index()
	{	
		// Chargement de la vue de Paiement
		$this->load->view('Paiement');
	}

	public function ValiderPaiement(){
		// Chargement des modèles de données
		$cartItemsModel = CartItemsModel::getInstance();
		$this->load->model('UserModel');
		$this->load->model('OrdersModel');

		// Suppression de tous les articles du panier de l'utilisateur
		if (isset($_SESSION['email'])){
			foreach($_SESSION['Orders'] as $id){
				$order  = $this->OrdersModel->findByID($id)[0];
				$product_id = $order->getProductId();
				$quantity = $order->getQuantity();

				$currentSells = $this->db->query("SELECT `nbSells` FROM `Products` WHERE `id` = '$product_id'")->row()->nbSells;
				$newSells = $currentSells + $quantity;
				$this->db->query("UPDATE `Products` SET `nbSells` = '$newSells' WHERE `id` = $product_id");
			}
			$user = $this->UserModel->findByLogin($_SESSION['email']);
			$res = $cartItemsModel->removeAll($user);	

			// Préparer le message de confirmation
			$message = "Vous avez passez une commande... elle est disponible pour un retrait en magasin\r\n";

			// Envoyer le message de confirmation
			mail($_SESSION['email'], 'Confirmation de création de compte', $message);

			$_SESSION['confirmationPaiement'] = "1";
			// Supression des données de commande en session et redirection
			unset($_SESSION['Orders']);

			redirect('Redirect');
		}

		redirect('Paiement');
	}

	public function AnnulerPaiement(){
		$this->load->model('OrdersModel');

		foreach($_SESSION['Orders'] as $id){
			$this->OrdersModel->removeOrder($id);
		}
		unset($_SESSION['Orders']);
		$_SESSION['erreurPaiement'] = "1";
		redirect('Panier');
	}
	
	
}



