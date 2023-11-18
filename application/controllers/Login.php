<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    public function index($params = NULL) {
        if (!empty($this->session->userdata('USER_EMAIL'))) {
        redirect(base_url('Missions'));
        } else {
            $datas['message'] = $params;
            $this->load->view('Login_View', $datas);
         }
    }

    public function do_login() {

        $login = $this->input->post('USERNAME');
        $password = $this->input->post('PASSWORD');
        
        $criteresmail['EMAIL']=$login;
         $user= $this->Model->getOne('adm_users',$criteresmail);



        if (!empty($user)) {
            
            if ($user['PASSWORD'] == md5($password))
			{

                $droits= $this->Model->getOne('adm_profiles',array('PROFIL_ID'=>$user['PROFIL_ID']));
           
                $session = array(
	                    'NOM' => $user['NOM'],
	                    'PRENOM' => $user['PRENOM'],
                        'TEL'=>$user['TEL'],
                        'LOGIN'=>$user['EMAIL'],
                        'PROFIL_ID'=>$user['PROFIL_ID'],
                        'CONNEXION_ID'=>$user['CONNEXION_ID'],
                        'ADMINISTRATION'=>$droits['ADMINISTRATION'],
                        'BI'=>$droits['BI'],
                        'IHM'=>$droits['IHM'],
	               );
                

	               $this->session->set_userdata($session);
	               redirect(base_url('index.php/administration/Users/liste'));
            }

             else
                $message = "<div class='alert alert-danger'> Le nom d'utilisateur ou/et mot de passe incorect(s) !</div>";
        }
         else
            $message = "<div class='alert alert-danger'> L'utilisateur n'existe pas/plus dans notre système informatique !</div>";
       $this->index($message);

    }

    public function do_logout()

		     {
		     
		            $session = array(
                        'NOM' => NULL,
	                    'PRENOM' => NULL,
                        'TEL'=>NULL,
                        'LOGIN'=>NULL,
                        'PROFIL_ID'=>NULL,
                        'CONNEXION_ID'=>NULL,
                        'ADMINISTRATION'=>NULL,
                        'IHM'=>NULL,
                        'BI'=>NULL
		                );

		        $this->session->set_userdata($session);
		        redirect(base_url());
		    }

}
