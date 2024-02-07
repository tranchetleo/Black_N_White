<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscription extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index(){	
		// Chargement de la vue d'inscription
		$this->load->view('Inscription');
	}

	public function create_account(){
		// Chargement des modèles de données
		$this->load->model('UserEntity');
		$this->load->model('UserModel');
		
		// Récupération des données du formulaire et protection contre les injections SQL
		$first_name = str_replace("'"," ", $this->input->post('prenom'));
		$last_name = str_replace("'"," ", $this->input->post('nom'));
		$email = str_replace("'"," ", $this->input->post('mail'));
		$password = $this->input->post('pass');
		$pass_conf = $this->input->post('pass_confirmation');
		$codeConfirmation = random_int(100000, 999999);
		
		// Vérification de la validité du mot de passe
		$validPass = false;
		$password_regex = "/(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?!.*[\s']).*$/";
		if((strpos($password, "'") == false) && ($password = $pass_conf) && (strlen($password)>=8) && (preg_match($password_regex, $password))){
			$validPass = true;
		}

		// Verrification des informarions et ajout de l'utilisateur dans la base de données
		if (($this->UserEntity->isEmail($email)) && ($password == $pass_conf) && ($validPass == true) && (!$this->UserModel->emailExists($email))){
			$res = $this->UserModel->add("User", array(
				$first_name,
				$last_name,
				$email,
				$password,
				$codeConfirmation
			));
			// Si l'ajout a réussi, on redirige vers la page de redirection
			if ($res){
				$user = $this->UserModel->findByLogin($email);
				redirect('Redirect');
			}
		}
		$_SESSION['erreurInscription'] = "1";
		// Si l'un des critères n'est pas respecté, on redirige vers la page d'inscription
		redirect('Inscription');
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



