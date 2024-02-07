<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPassword extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}


	public function index(){	
		// Chargement de la vue de réinitialisation de mot de passe
		$this->load->view('ForgotPassword');
	}

	public function sendNewPassword(){
		// Chargement du modèle de données
		$this->load->model('UserModel');
		
		// Récupération de l'adresse email entrée dans le formulaire
		$email = strtolower($this->input->post('mail'));
		
		// Si l'adresse email existe dans la base de données : génération et envoi d'un nouveau mot de passe à l'utilisateur
		if ($this->UserModel->emailExists($email)){
			$this->UserModel->autoChangePassword($email);
		}

		// Chargement de la vue de redirection
		$this->load->view('Redirect');
	}
}



