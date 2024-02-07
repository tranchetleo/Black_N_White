<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InscriptionAdmin extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){	
		// Chargement de la vue d'inscription
		$this->load->view('InscriptionAdmin');
	}

	public function create_account(){
		// Chargement des modèles de données
		$this->load->model('UserEntity');
		$this->load->model('UserModel');
		
		// Récupération des données du formulaire et protection contre les injections SQL
		$login = str_replace("'"," ", $this->input->post('login'));
		$password = $this->input->post('pass');
		$pass_conf = $this->input->post('pass_confirmation');
		
		// Vérification de la validité du mot de passe
		$validPass = false;
		$password_regex = "/(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?!.*[\s']).*$/";
		if((strpos($password, "'") == false) && ($password = $pass_conf) && (strlen($password)>=8) && (preg_match($password_regex, $password))){
			$validPass = true;
		}

		// Verrification des informarions et ajout de l'utilisateur dans la base de données
		if (($password == $pass_conf) && ($validPass == true) && (!$this->UserModel->adminExists($login))){
			$res = $this->UserModel->add("Admin", array(
				$login,
				$password
			));
			// Si l'ajout a réussi, on redirige vers la page de redirection
			if ($res){
				$user = $this->UserModel->findAdmin($login);
				redirect('Redirect');
			}
		}
		// Si l'un des critères n'est pas respecté, on redirige vers la page d'inscription
		redirect('InscriptionAdmin');
	}


	public function account_validation(int $id, int $validation_code){
		// Chargement du modèle de données des utilisateurs
		$this->load->model('UserModel');
		
		// Validation de l'utilisateur avec l'ID et le code de validation donnés en paramètre
		$res = $this->UserModel->validate($id, $validation_code);
		
		// Redirection vers la page de validation
		redirect('Validation');
	}
}



