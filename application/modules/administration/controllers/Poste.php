<?php 

		
		/**
		 * 
		 */
		class Poste extends CI_Controller
		{
			
			function __construct()
			{
				parent::__construct();
			}

			function index(){

				  $this->make_bread->add('Nouveau poste', "administration/Poste", 0);
        		 
        		  $data['breadcrumb'] = $this->make_bread->output();


				$this->load->view('administration/Poste_Add_View',$data);
			}
		}
 ?>