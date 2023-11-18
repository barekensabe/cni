<?php 
		/** ALEXIS BADIA
		 * 79839653
		 * barekensabealexiss@gmail.com
		 */
		class Profils extends CI_Controller
		{
			
			function __construct()
			{
				parent::__construct();
			}

			//FONCTION POUR AFFICHER L'INTERFACE D'AJOUT D'UN PROFIL ET LEUR DROITS
			function index(){

			$this->make_bread->add('Nouveau poste', "administration/Profils", 0);
        		 
        	$data['breadcrumb'] = $this->make_bread->output();

           $this->load->view('user_view/Profil_Add_View',$data);
			}


			//FUNCTION POUR AJOUTER UN PROFIL
			function add()
			{
		  
		   $this->form_validation->set_rules('DESC_PROFIL','Profil Description','trim|required|is_unique[adm_profiles.DESC_PROFIL]');
		  
		 if($this->form_validation->run()==true)
		  
			{
				
			   if($this->input->post('ADMINISTRATION') != null)
				 { $ADMINISTRATION= 1;}else{ $ADMINISTRATION= 0; }
		  
			   if($this->input->post('BI') != null)
				 { $BI= 1;}else{ $BI= 0; }

			   if($this->input->post('IHM') != null)
				 { $IHM= 1;}else{ $IHM= 0; }
			  
			  $DESC_PROFIL=$this->input->post('DESC_PROFIL');
			   
		  
					$datadroit= array('DESC_PROFIL'=>$DESC_PROFIL,
									  'ADMINISTRATION'=>$ADMINISTRATION,
									  'BI'=>$BI,
									  'IHM'=>$IHM);
									
				    $idprofile= $this->Model->insert_last_id("adm_profiles",$datadroit);
					$data['message'] = "<div class='alert alert-success'>Enregistrement d'un profils et droits fait avec succes</div>";

				  
			$this->session->set_flashdata($data);
			redirect(base_url('index.php/administration/Profils/liste'));
			}
			else
			{
				$this->make_bread->add('Nouveau poste', "administration/Profils", 0);
        		 
				$data['breadcrumb'] = $this->make_bread->output();
	
			   $this->load->view('user_view/Profil_Add_View',$data);	
			}

			}


    //FONCTION POUR LISTER TOUS LES PROFILS
    function liste(){

        $profiles = $this->Model->getRequete('SELECT * FROM `adm_profiles`');

        $profils_list = array();
        foreach ($profiles as $profile) {
            $array = NULL;
            $array['DESC_PROFIL'] = $profile['DESC_PROFIL'];
			if($profile['ADMINISTRATION'] == 1)
			{ $array['ADMINISTRATION']= "<div class='bg-success text-center'><span class='glyphicon glyphicon-ok-sign'></span></div>";}
		  else
		   { $array['ADMINISTRATION']= "<div class='bg-danger text-center'><span class='glyphicon glyphicon-minus-sign'></span></div>"; }
		 if($profile['IHM'] == 1)
			{ $array['IHM']= "<div class='bg-success text-center'><span class='glyphicon glyphicon-ok-sign'></span></div>";}
		  else
		   { $array['IHM']= "<div class='bg-danger text-center'><span class='glyphicon glyphicon-minus-sign'></span></div>"; }
		 if($profile['BI'] == 1)
			{ $array['BI']= "<div class='bg-success text-center'><span class='glyphicon glyphicon-ok-sign'></span></div>";}
		  else
		   { $array['BI']= "<div class='bg-danger text-center'><span class='glyphicon glyphicon-minus-sign'></span></div>"; }
		 

          $array['OPTIONS'] = '<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        ';

            $array['OPTIONS'] .= "<li><a href='" . base_url('index.php/administration/Profils/getone/' . $profile['PROFIL_ID']) . "'>Modifier</a></li>";


            $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#mydelete" . $profile['PROFIL_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
                  </div>
                                    <div class='modal fade' id='mydelete" . $profile['PROFIL_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous supprimer l'utilisateur <b>" . $profile['DESC_PROFIL']. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" .base_url('index.php/administration/Profils/delete/' . $profile['PROFIL_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
        $profils_list[] =$array;
        }
         $template = array(
            'table_open' => '<table id="profils_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('PROFILE','ADMINISTRATION','IHM','BI','OPTIONS');
        $this->table->set_template($template);
        $data['profils_list'] = $profils_list;

        $data['breadcrumb'] = $this->make_bread->output();
        
        $this->load->view('user_view/Profil_Liste_View', $data);
    }














		}
 ?>