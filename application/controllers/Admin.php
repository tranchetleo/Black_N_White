<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){		
		// Récupération du contenu du panier
		if (isset($_SESSION['isLoged'])){
			//Chargement des modèles de données
			$this->load->model('ProductModel');
			$this->load->model('UserModel');
			$_SESSION['AdminSearch'] = "";

			// Chargement de la vue de recherche
			$products = $this->ProductModel->findAll();
			$users = $this->UserModel->findAll();
			$data = array("prods"=>$products, "users"=>$users);
			$this->load->view('RechercheAdmin', $data);
		} else {
			$this->load->view('Admin');
		}
	}

	public function updateSession($login){
		// Récupération de l'utilisateur
		$user = $this->UserModel->findAdmin($login);

		// Enregistrement des données de session
		$_SESSION['login'] = $login;
		$this->session->set_userdata(array(
			$login
		));
	}

	public function login(){
		// Chargement du modèle de données
		$this->load->model('UserModel');
	
		// Récupération des données du formulaire et protection contre les injections SQL
		$login = strtolower($this->input->post('login'));
		$password = $this->input->post('pass');
		$login = str_replace("'"," ", $login);
		$password = str_replace("'"," ", $password);
	
		// Tentative de connexion
		$res = $this->UserModel->connexionAdmin(array(
			$login,
			$password
		));
		
		// Si la connexion a réussi
		if ($res){
			$this->updateSession($login);
			$_SESSION['isLoged'] = true;
			$_SESSION['AdminSearch'] = "";
			
			// Redirection vers la page d'accueil
			$products = array();
			$users = array();
			$data = array("prods"=>$products, "users"=>$users);
			$this->load->view('RechercheAdmin', $data);
		}
		// Sinon
		else {
			// Redirection vers la page de connexion
			redirect('Admin');
		}
	}

	public function logout(){
		// Déconnexion de l'utilisateur en détruisant la session
		$this->session->sess_destroy();
		
		// Redirection vers la page d'accueil
		redirect('Admin');
	}

	
}



