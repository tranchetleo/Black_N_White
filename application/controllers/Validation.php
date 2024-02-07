<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends CI_Controller {

	public function __construct() {
		// Appel du constructeur du parent
		parent::__construct();
		
		// Chargement de l'helper URL
		$this->load->helper('url');
	}

	public function index()
	{	
		// Chargement de la vue de validation
		$this->load->view('Validation');
	}

	
}



