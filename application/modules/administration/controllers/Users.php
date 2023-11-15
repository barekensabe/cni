
<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->is_Oauth();
        $this->make_bread->add('Users', "Users", 0);
        $this->breadcrumb = $this->make_bread->output();

    }

    // public function is_Oauth()
    // {
    //    if($this->session->userdata('USER_EMAIL') == NULL)
    //     redirect(base_url());
    // }

    //FONCTION POUR AFFICHER L'INTERFACE D'AJOUT D'UN NOUVEAU UTILISATEUR
    function index() {
        $this->make_bread->add('Nouvel utilisateur', "Users", 1);
        $data['breadcrumb'] = $this->make_bread->output();
        $data['profiles']=$this->Model->getList('adm_profiles');
        $this->load->view('user_view/User_Add_View', $data);
    }

   //FONCTION POUR AJOUTER UN NOUVEAU UTILISATEUR
    public function add() {
         
        $this->form_validation->set_rules('NOM', 'nom', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme nom</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>")); 
        $this->form_validation->set_rules('PRENOM', 'nom', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme nom</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>")); 
        $this->form_validation->set_rules('TEL', 'telephone', 'trim|required|is_unique[adm_users.TEL]',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme telephone</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>"));
        $this->form_validation->set_rules('EMAIL', 'E-mail', 'trim|required|is_unique[adm_users.EMAIL]',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme E-mail</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>"));
        $this->form_validation->set_rules('PROFIL_ID', 'profil','trim|required',array('required'=>"<font size='2em', color='red'><i>Veuillez choisir un profil</i></font>"));
        $this->make_bread->add('Nouvel', "Users", 1);
        $data['breadcrumb'] = $this->make_bread->output();
       
        if ($this->form_validation->run() == FALSE) {
            $data['NOM'] = $this->input->post('NOM');
            $data['PRENOM'] = $this->input->post('PRENOM');
            $data['TEL'] = $this->input->post('TEL');
            $data['EMAIL'] = $this->input->post('EMAIL');
            $data['PROFIL_ID'] = $this->input->post('PROFIL_ID');
            $data['profiles']=$this->Model->getList('adm_profiles');

            $this->load->view('user_view/User_Add_View', $data);
        } else {
            
            $donnee = array(
                'NOM' => $this->input->post('NOM'),
                'PRENOM' => $this->input->post('PRENOM'),
                'TEL' => $this->input->post('TEL'),
                'EMAIL'=>$this->input->post('EMAIL'),
                'PROFIL_ID'=>$this->input->post('PROFIL_ID'),
                'PASSWORD'=>md5('12345')
            );

            $user_id = $this->Model->insert_last_id('adm_users', $donnee);
 
            $data['message'] = "<div class='alert alert-danger'>Enregistrement fait avec succes</div>";
            redirect(base_url('index.php/administration/Users/liste'));
        }
    }


    //FONCTION POUR LISTER TOUS LES UTILISATEURS
    function liste(){

        $users = $this->Model->getRequete('SELECT CONNEXION_ID,adm_users.NOM,adm_users.PRENOM,adm_users.TEL,adm_users.EMAIL,adm_profiles.DESC_PROFIL FROM `adm_users` JOIN adm_profiles ON adm_profiles.PROFIL_ID=adm_users.PROFIL_ID WHERE 1');

        $user_list = array();
        foreach ($users as $user) {
            $array = NULL;
            $array['NOM'] = $user['NOM'];
            $array['PRENOM'] = $user['PRENOM'];
            $array['TEL'] = $user['TEL'];
            $array['EMAIL'] = $user['EMAIL'];
            $array['DESC_PROFIL'] = $user['DESC_PROFIL'];

            $array['OPTIONS'] = '<div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        ';

            $array['OPTIONS'] .= "<li><a href='" . base_url('index.php/administration/Users/getone/' . $user['CONNEXION_ID']) . "'>Modifier</a></li>";


            $array['OPTIONS'] .= "<li><a hre='#' data-toggle='modal' 
                                  data-target='#mydelete" . $user['CONNEXION_ID'] . "'><font color='red'>Supprimer</font></a></li></ul>
                  </div>
                                    <div class='modal fade' id='mydelete" . $user['CONNEXION_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Voulez-vous supprimer l'utilisateur <b>" . $user['NOM'].' '. $user['PRENOM']. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" .base_url('index.php/administration/Users/delete/' . $user['CONNEXION_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Quitter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>";
        $user_list[] =$array;
        }
         $template = array(
            'table_open' => '<table id="user_list" class="table table-bordered table-striped table-hover table-condensed table-responsive">',
            'table_close' => '</table>'
        );

        $this->table->set_heading('NOM','PRENOM','TELEPHONE','EMAIL','PROFIL','OPTIONS');
        $this->table->set_template($template);
        $data['user_list'] = $user_list;

        $data['breadcrumb'] = $this->breadcrumb;
        
        $this->load->view('user_view/User_Liste_View', $data);
    }


    //FONCTION POUR AFFICHER LES INFOS D'UN UTILISATEUR A MODIFIER
    function getone($CONNEXION_ID) {
        $this->make_bread->add('Modification utilisateur', "Users", 1);
        $data['breadcrumb'] = $this->make_bread->output();
        $data['profiles']=$this->Model->getList('adm_profiles');
        $data['datas']=$this->Model->getRequeteOne('SELECT adm_users.*,adm_profiles.PROFIL_ID,adm_profiles.DESC_PROFIL FROM `adm_users` JOIN adm_profiles ON adm_profiles.PROFIL_ID=adm_users.PROFIL_ID WHERE CONNEXION_ID='.$CONNEXION_ID);
        $this->load->view('user_view/User_Modifier_View', $data);
    }

   //FONCTION POUR MODIFIER UN  UTILISATEUR
   public function update() {
   
    $this->form_validation->set_rules('NOM', 'nom', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme nom</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>")); 
    $this->form_validation->set_rules('PRENOM', 'nom', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme nom</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>")); 
    $this->form_validation->set_rules('TEL', 'telephone', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme telephone</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>"));
    $this->form_validation->set_rules('EMAIL', 'E-mail', 'trim|required',array('is_unique'=>"<font size='2em', color='red'><i>il y a un autre utilisateur avec le meme E-mail</i></font>",'required'=>"<font size='2em', color='red'><i>Ce champs est requis</i></font>",'trim'=>"<font size='2em', color='red'><i>Ce champs ne doit pas être vide</i></font>"));
    $this->form_validation->set_rules('PROFIL_ID', 'profil','trim|required',array('required'=>"<font size='2em', color='red'><i>Veuillez choisir un profil</i></font>"));
 
    if ($this->form_validation->run() == FALSE) {


        $this->make_bread->add('Modification utilisateur', "Users", 1);
        $data['breadcrumb'] = $this->make_bread->output();
        $data['profiles']=$this->Model->getList('adm_profiles');
        $data['datas']=$this->Model->getRequeteOne('SELECT adm_users.*,adm_profiles.PROFIL_ID,adm_profiles.DESC_PROFIL FROM `adm_users` JOIN adm_profiles ON adm_profiles.PROFIL_ID=adm_users.PROFIL_ID WHERE CONNEXION_ID='.$CONNEXION_ID);
        $this->load->view('user_view/User_Modifier_View', $data);
    } else {

        $CONNEXION_ID=$this->input->post('CONNEXION_ID');
        $donnee = array(
            'NOM' => $this->input->post('NOM'),
            'PRENOM' => $this->input->post('PRENOM'),
            'TEL' => $this->input->post('TEL'),
            'EMAIL'=>$this->input->post('EMAIL'),
            'PROFIL_ID'=>$this->input->post('PROFIL_ID')
        );

        $this->Model->update('adm_users', array('CONNEXION_ID' => $CONNEXION_ID), $donnee);

        $data['message'] = "<div class='alert alert-danger'>Modification fait avec succes</div>";
        redirect(base_url('index.php/administration/Users/liste'));
    }
}


    //FONCTION POUR SUPPRIMER LES INFOS D'UN UTILISATEUR A MODIFIER
    function delete($CONNEXION_ID) {
        $this->Model->delete('adm_users', array('CONNEXION_ID' => $CONNEXION_ID));
        $data['message'] = "<div class='alert alert-danger'>Suppression fait avec succes</div>";
        redirect(base_url('index.php/administration/Users/liste'));
    }




}

?>
