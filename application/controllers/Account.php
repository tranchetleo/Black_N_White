<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."CartItemsModel.php";

class Account extends CI_Controller {

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

		// Chargement de la vue avec comme parametre le contenu du pannier
		$data = array("cartItems"=>$products);
		$this->load->view('Account', $data);
	}

	public function logOut(){
		// Suppression des éléments de session
		$array_items = array('email', 'name', 'lastname');
		$this->session->unset_userdata($array_items);
		
		// Redirection vers la page d'accueil
		redirect('Home');
	}

	public function changePassword(){
		// Chargement des modèles de données
		$this->load->model('UserModel');
	
		// Récupération des données du formulaire
		$password = ($this->input->post('pass'));
		$newPassword = ($this->input->post('new_pass'));
		$confPassword = ($this->input->post('pass_confirmation'));
	
		// Tentative de modification du mot de passe
		$res = $this->UserModel->changePassword(array(
			$password,
			$newPassword,
			$confPassword
		));
	
		// Si la modification a réussi
		if ($res){
			// Suppression des données de session
			$array_items = array('email', 'name', 'lastname');
			$this->session->unset_userdata($array_items);
	
			// Redirection vesr la page de redirection
			redirect('Redirect');
		}
		// Sinon
		else {
			// Redirection vers la page de compte
			redirect('Account');
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

	public function updateUserInfo(){
		// Chargement du modèle de données des utilisateurs
		$this->load->model('UserModel');

		// Récupération de l'utilisateur connecté
		$user = $this->UserModel->findByLogin($_SESSION['email']);

		// Récupération des données du formulaire
		$firstName = ($this->input->post('prenom'));
		$lastName = ($this->input->post('nom'));
		$email = ($this->input->post('mail'));
		$changeemail = false;

		if($email !== $user->getEmail()){
			$codeConfirmation = random_int(100000, 999999);
			$message = "Vous avez modifier vos informations personelles, cliquez sur ce lien pour activer valider votre nouvelle adresse mail.\r\n
			https://www.sani-web.com/Black_N_White/index.php/Inscription/account_validation/".$user->getId()."/".$codeConfirmation;
			mail($email, "Validation d'adresse mail", $message);
			// Mise à jour des informations de l'utilisateur pour valider son mail
			$user->setConfirmarionCode($codeConfirmation);
			$user->setActive(0);
			$changeemail = true;
		}

		// Mise à jour des informations de l'utilisateur
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setEmail($email);

		// Enregistrement des modifications dans la base de données
		$this->UserModel->update($user);

		// Redirection vers la vue Redirect si le mail a été changé
		if($changeemail == true){
			// Suppression des éléments de la session
			session_destroy();
			redirect('Connexion');
		} else {
			$this->updateSession($email);
			$_SESSION['infoUpdated'] = "1";
			redirect('Account');
		}
	}
}



