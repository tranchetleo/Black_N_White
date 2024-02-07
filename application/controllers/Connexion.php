<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Connexion extends CI_Controller {

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
		
		// Préparation des données à envoyer à la vue
		$data = array("cartItems"=>$products);
		
		// Chargement de la vue appropriée en fonction de la connexion de l'utilisateur
		if (isset($_SESSION['email'])){
			$this->load->view('Account', $data);
		} else {
			$this->load->view('Connexion', $data);
		}
	}

	public function updateSession($email){
		// Récupération de l'utilisateur
		$user = $this->UserModel->findByLogin($email);

		// Enregistrement des données de session
		$_SESSION['email'] = $email;
		$_SESSION['name'] = $user->getFirstName();
		$_SESSION['lastname'] = $user->getLastName();
		$_SESSION['user_id'] = $user->getId();
		$_SESSION['erreurPanier'] = "0";
		$this->session->set_userdata(array(
			$email,
			$user->getFirstName(),
			$user->getLastName(),
			$user->getId()
		));
	}

	public function login(){
		// Chargement du modèle de données
		$this->load->model('UserModel');
	
		// Récupération des données du formulaire et protection contre les injections SQL
		$email = strtolower($this->input->post('mail'));
		$password = $this->input->post('pass');
		$email = str_replace("'"," ", $email);
		$password = str_replace("'"," ", $password);
	
		// Tentative de connexion
		$res = $this->UserModel->connexion(array(
			$email,
			$password
		));
		
		// Si la connexion a réussi
		if ($res){
			$this->updateSession($email);
			
			// Redirection vers la page d'accueil
			redirect('Home');
		}
		// Sinon
		else {
			$_SESSION['erreurConnexion'] = "1";
			// Redirection vers la page de connexion
			redirect('Connexion');
		}
	}

	public function logout(){
		// Déconnexion de l'utilisateur en détruisant la session
		$this->session->sess_destroy();
		
		// Redirection vers la page d'accueil
		redirect('Home');
	}

	public function deleteUser() {
		// Chargement du modèle de données
		$this->load->model('UserModel');

		$email = $_SESSION['email'];
		// Récupération de l'utilisateur
		$user = $this->UserModel->findByLogin($email);
		$id = $user->getId();
		$this->db->where('id', $id);
		$this->db->delete('Users');

		// Déconnexion de l'utilisateur en détruisant la session
		$this->session->sess_destroy();

		// Redirection vers la page d'accueil
		redirect('Connexion');
	}
	
}



