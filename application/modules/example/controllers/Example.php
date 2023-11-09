<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {
	public function __construct() {
        parent::__construct();
        //$this->is_Oauth();
        $this->make_bread->add('Example', "Example", 0);
        $this->breadcrumb = $this->make_bread->output();
    }

	public function example_add(){
		$data['breadcrumb'] = $this->make_bread->output();
		$this->load->view('example_view/Example_Add_View',$data);

	}
	public function example_list(){
		$data['breadcrumb'] = $this->make_bread->output();
		$this->load->view('example_view/Example_List_View',$data);
		
	}
}
