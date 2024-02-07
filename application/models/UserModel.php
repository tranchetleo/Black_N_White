<?php

require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."UserEntity.php";
require_once APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."AdminEntity.php";
class UserModel extends CI_Model {

	public function findAll()
	{
		$this->db->select('*');
		$query = $this->db->get('Users');
		return $query->custom_result_object("UserEntity");
	}

    public function findByLogin(string $login){
		$query = $this->db->get_where('Users', ['email' => $login]);
		$result = $query->row(0, 'UserEntity');
	
		if (!$result) {
			return null;
		}
	
		return $result;
    }

	public function findAdmin(string $login){
		$query = $this->db->get_where('Admins', ['login' => $login]);
		$result = $query->row(0, 'AdminEntity');
	
		if (!$result) {
			return null;
		}
	
		return $result;
    }

	function findByKeyWords(array $listKW, string $tri, string $filtres){
		$string = "Users WHERE ((`first_name` LIKE ('%".$listKW[0]."%')) OR (`last_name` LIKE ('%".$listKW[0]."%') OR `email` LIKE ('%".$listKW[0]."%') OR `id` LIKE ('%".$listKW[0]."%')))";
		foreach($listKW as $kw){
			$string .= "AND ((`first_name` LIKE ('%".$kw."%')) OR (`last_name` LIKE ('%".$kw."%') OR `email` LIKE ('%".$kw."%') OR `id` LIKE ('%".$kw."%')))";
		}
		$string .= $filtres;
		$string .= $tri;
		$q = $this->db->get($string);
		$response = $q->custom_result_object("UserEntity");
	    return $response;
	}

	public function emailExists(string $email) {
		$query = $this->db->get_where('Users', ['email' => $email]);
		return $query->num_rows() > 0;
	}

	public function adminExists(string $login) {
		$query = $this->db->get_where('Admins', ['login' => $login]);
		return $query->num_rows() > 0;
	}

	public function addUser(array $data){
		// Mettre l'adresse email en minuscule pour éviter les doublons
		$data[2] = strtolower($data[2]);

		// Hasher le mot de passe
		$hashedPassword = password_hash($data[3], PASSWORD_DEFAULT);
	
		// Préparer la requête d'insertion
		$query = $this->db->insert_string('Users', [
			'first_name' => $data[0],
			'last_name' => $data[1],
			'email' => $data[2],
			'hashed_password' => $hashedPassword,
			'confirmation_code' => $data[4]
		]);
	
		// Exécuter la requête d'insertion et vérifier si l'opération a réussi
		if ($this->db->query($query)) {
			// Récupérer l'ID de l'utilisateur inséré
			$userId = $this->findByLogin($data[2])->getId();
	
			// Préparer le message de confirmation
			$message = "Vous avez essayer de créer un compte sur le site Black N White, veuillez cliquer sur le lien ci-dessous pour terminer la création de votre compte\r\n"
				. $data[4] . "\r\nhttp://srv-infoweb.iut-nantes.univ-nantes.prive/~E215035J/SAE/index.php/Inscription/account_validation/"
				. $userId . "/" . $data[4];
	
			// Envoyer le message de confirmation
			mail($data[2], 'Confirmation de création de compte', $message);
	
			return true;
		} else {
			return false;
		}
	}

	public function addAdmin(array $data){
		// Hasher le mot de passe
		$hashedPassword = password_hash($data[1], PASSWORD_DEFAULT);
	
		// Préparer la requête d'insertion
		$query = $this->db->insert_string('Admins', [
			'login' => $data[0],
			'hashed_password' => $hashedPassword
		]);
	
		// Exécuter la requête d'insertion et vérifier si l'opération a réussi
		if ($this->db->query($query)) {
			// Récupérer l'ID de l'utilisateur inséré
			$userId = $this->findAdmin($data[0])->getId();
			return true;
		} else {
			return false;
		}
	}

	public function add($type, array $data): bool {
		$res = false;
		if($type == "User"){
			$res = $this->addUser($data);
		} elseif($type == "Admin"){
			$res = $this->addAdmin($data);
		}
		return $res;
	}

	public function connexion(array $data): bool {
		// Récupérer l'utilisateur correspondant à l'adresse email fournie
		$user = $this->findByLogin($data[0]);
	
		// Vérifier si l'utilisateur existe et si son compte est actif
		if ($user && $user->isActive()) {
			// Vérifier si le hash du mot de passe fourni correspond au hash stocké en base de données
			return password_verify($data[1], $user->getHashedPassword());
		} else {
			return false;
		}
	}

	public function connexionAdmin(array $data): bool {
		// Récupérer l'utilisateur correspondant au login fournie
		$admin = $this->findAdmin($data[0]);
	
		// Vérifier si l'utilisateur existe et si son compte est actif
		if ($admin && $admin->isActive()) {
			// Vérifier si le hash du mot de passe fourni correspond au hash stocké en base de données
			return password_verify($data[1], $admin->getHashedPassword());
		} else {
			return false;
		}
	}

	public function validate(int $id, int $validation_code): bool {
		// Préparation de la requête de sélection
		$this->db->select('*');
		$this->db->from('Users');
		$this->db->where('id', $id);
		$this->db->where('confirmation_code', $validation_code);
		// Exécution de la requête
		$query = $this->db->get();
		// Vérification du nombre de résultats obtenus
		if ($query->num_rows() == 1) {
			// Préparation de la requête de mise à jour
			$this->db->set('active', 1);
			$this->db->where('id', $id);
			$this->db->update('Users');
			// Vérification du nombre de lignes affectées par la requête de mise à jour
			return $this->db->affected_rows() == 1;
		}
		return false;
	}

	public function autoChangePassword(string $email): bool {
		// Génération du nouveau mot de passe aléatoire
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$newpassword = "";
		for ($i = 0; $i < 12; $i++) {
		  $n = rand(0, strlen($alphabet)-1);
		  $newpassword .= $alphabet[$n];
		}
		$hashed_newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
	  
		// Mise à jour du mot de passe dans la base de données
		$this->db->set('hashed_password', $hashed_newpassword);
		$this->db->where('email', $email);
		$this->db->update('Users');
	  
		// Envoi du nouveau mot de passe par email
		if ($this->db->affected_rows() == 1) {
		  $subject = 'Changement de mot de passe';
		  $message = "Vous avez tenté de changer de mot de passe, votre nouveau mot de passe est :\r\n" . $newpassword . "\r\n";
		  mail($email, $subject, $message);
		  return true;
		}
		return false;
	}

	public function changePassword(array $data): bool {
		$password = str_replace("'", " ", $data[0]);
		$newPassword = str_replace("'", " ", $data[1]);
		$confPassword = str_replace("'", " ", $data[2]);
	
		// Récupérer le mot de passe hashé de l'utilisateur dans la base de données
		$this->db->select('hashed_password');
		$this->db->where('email', $_SESSION['email']);
		$query = $this->db->get('Users');
		$hashed_password_from_database = $query->row()->hashed_password;
	
		// Vérifier que les deux nouveaux mots de passe sont identiques et que l'ancien mot de passe est correct
		if ($newPassword == $confPassword && password_verify($password, $hashed_password_from_database)) {
			$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$email = $_SESSION['email'];
	
			// Mettre à jour le mot de passe de l'utilisateur
			$query = $this->db->query("UPDATE `Users` SET `hashed_password` = '$newPassword' WHERE `email` = '$email'", [$newPassword, $email]);
			if ($query) {
				// Préparer le message de confirmation
				$message = "Vous avez tenté de changer de mot de passe. Le mot de passe a bien été changé.\r\n";
	
				// Envoyer le message de confirmation
				mail($email, 'Changement de mot de passe', $message);
	
				return true;
			}
		}
	
		return false;
	}

	public function update(UserEntity $user){
		// Vérifie si l'adresse e-mail est déjà utilisée par un autre utilisateur
		$query = $this->db->get_where('Users', array('email' => $user->getEmail()));
		if ($query->num_rows() > 0) {
			$result = $query->row();
			if ($result->id != $user->getId()) {
				return 'Il existe un compte avec la même adresse email.';
			}
		}

		// Met à jour l'enregistrement de l'utilisateur dans la base de données
		$data = array(
			'first_name' => $user->getFirstName(),
			'last_name' => $user->getLastName(),
			'email' => $user->getEmail(),
			'confirmation_code' => $user->getConfirmarionCode(),
			'active' => $user->getActive()
		);
		$this->db->where('id', $user->getId());
		return $this->db->update('Users', $data);
	}

}
?>
