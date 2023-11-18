<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model{

  function __construct() {
  parent::__construct();
  
    }

    function getRequete($requete){
        $query=$this->db->query($requete);
        if ($query) {
           return $query->result_array();
        }
      }
       function getRequeteOne($requete){
        $query=$this->db->query($requete);
        if ($query) {
           return $query->row_array();
        }
      }

      public function datatable($requete)//make_datatables : requete avec Condition,LIMIT start,length
      { 
             $query =$this->maker($requete);//call function make query
             return $query->result();
           }  
         public function maker($requete)//make query
         {
           return $this->db->query($requete);
         }
     
         public function all_data($requete)//count_all_data : requete sans Condition sans LIMIT start,length
         {
            $query =$this->maker($requete); //call function make query
            return $query->num_rows();   
          }
          public function filtrer($requete)//get_filtered_data : requete avec Condition sans LIMIT start,length
          {
              $query =$this->maker($requete);//call function make query
              return $query->num_rows();
              
            }
    

	function create($table, $data) {

        $query = $this->db->insert($table, $data);
        return ($query) ? true : false;

    }
    public function countHeureMission($critere)
    {
      $this->db->select('SUM(NB_HEURE_PREVUES) as nbre')
                ->from('phases')
                ->where($critere);
        $query = $this->db->get();

        if ($query) {
            return $query->row()->nbre;
        }
    }

   public function getDiligencesMacac($ID_MACAC)
    {
       $this->db->select('dlg.*');
       $this->db->from('diligences dlg');
       $this->db->join('phases ph','ph.ID_PHASE=dlg.ID_PHASE');
       $this->db->where('ph.ID_MACAC',$ID_MACAC);

       $query = $this->db->get();
       if($query){
         return $query->result_array();
       }
    }
    public function getDataCraDiligence($ID_DILIGENCE,$date)
  {
    $this->db->select();
    $this->db->where('ID_DILIGENCE',$ID_DILIGENCE);
    $this->db->where("DATE_CRA LIKE '%$date%'");
    $this->db->order_by('ID_CRA','DESC');
    $query = $this->db->get('cra');

   if($query){
      return $query->row_array();
   }
  }
    public function collaboPhase($ID_PHASE)
    {
      $this->db->distinct('af.ID_COLLABORATEUR');
      $this->db->select('af.ID_COLLABORATEUR');
      $this->db->from('affectations af');
      $this->db->join('diligences dl','dl.ID_DILIGENCE = af.ID_DILIGENCE');
      $this->db->where('dl.ID_PHASE',$ID_PHASE);
      
      $query = $this->db->get();

      if($query){
        return $query->result_array();
      }
    }

    public function collaboMacac($ID_MACAC)
    {
      $this->db->distinct('af.ID_COLLABORATEUR');
      $this->db->select('af.ID_COLLABORATEUR');
      $this->db->from('affectations af');
      $this->db->join('diligences dl','dl.ID_DILIGENCE = af.ID_DILIGENCE');
      $this->db->join('phases ph','dl.ID_PHASE = ph.ID_PHASE');
      $this->db->where('ph.ID_MACAC',$ID_MACAC);
      
      $query = $this->db->get();

      if($query){
        return $query->result_array();
      }
    }

    public function getCollaboPhase($ID_COLLABORATEUR,$ID_PHASE)
    {
       $this->db->select("SUM(cr.NB_HEURE_INVEST) as nb_hr_invest");
       $this->db->from('cra cr');
       $this->db->join('diligences dlg',"cr.ID_DILIGENCE = dlg.ID_DILIGENCE");
       $this->db->where("cr.ID_COLLABO",$ID_COLLABORATEUR);
       $this->db->where("dlg.ID_PHASE",$ID_PHASE);
       $this->db->group_by("dlg.ID_PHASE");
       
       $query = $this->db->get();
       if($query){
        return $query->row_array();
       }
    }

    public function getCollaboHeureMacac($ID_COLLABORATEUR,$ID_MACAC)
    {
       $this->db->select("SUM(cr.NB_HEURE_INVEST) as nb_hr_invest");
       $this->db->from('phases ph');
       $this->db->join('diligences dlg','ph.ID_PHASE=dlg.ID_PHASE');
       $this->db->join('cra cr',"cr.ID_DILIGENCE = dlg.ID_DILIGENCE");
       $this->db->where("cr.ID_COLLABO",$ID_COLLABORATEUR);
       $this->db->where("ph.ID_MACAC",$ID_MACAC);
       $this->db->group_by("ph.ID_PHASE");
       
       $query = $this->db->get();
       if($query){
        return $query->row_array();
       }
    }


    
    function insert_batch($table,$data){
      
    $query=$this->db->insert_batch($table, $data);
    return ($query) ? true : false;
    //return ($query)? true:false;

    }
    function getListLimit($table,$limit)
    {
     $this->db->limit($limit);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }
    function getListLimit2($table,$limit,$cond=array())
    {
     $this->db->limit($limit);
     $this->db->where($cond);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }

    function getListLimitwhere($table,$criteres = array(),$limit = NULL)
    {
      $this->db->limit($limit);
      $this->db->where($criteres);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }

  

    function getList_distinct($table,$distinct=array()) {
        $this->db->select($distinct);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_distinct2($table,$distinct=array(),$criteres=array()) {
      $this->db->where($criteres);
        $this->db->select($distinct);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_between($table,$critere=array(),$criteres=array()){
        $this->db->where('NBRE_PIECES_PRINCIPALES >=', $critere);
$this->db->where('NBRE_PIECES_PRINCIPALES <=', $criteres);
return $this->db->get($table);
    }

  function update($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update($table, $data);
        return ($query) ? true : false;
    }
    function update_batch($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update_batch($table, $data);
        return ($query) ? true : false;
    }
  function update_table($table, $criteres, $data) {
        foreach ($data as $key => $value) {
          $this->db->set($key,$value);
        }
        $this->db->where($criteres);
        $query = $this->db->update($table);
        return ($query) ? true : false;
    }  

    function insert_last_id($table, $data) {

        $query = $this->db->insert($table, $data);
       
       if ($query) {
            return $this->db->insert_id();
        }

    }

    public function getOneOrder($table,$array= array(),$order_champ,$order_value = 'DESC')
       {
         $this->db->where($array);
         $this->db->order_by($order_champ,$order_value);

         $query = $this->db->get($table);

         if($query){
          return $query->row_array();
         }
       }   


    function getList($table,$criteres = array()) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getListTime($table,$criteres = array(),$time = NULL) {
        $this->db->where($criteres);
        $this->db->where($time);
        $query = $this->db->get($table);
        return $query->result_array();
    }


    function getListOrdertwo($table,$criteres = array(),$order) {
        $this->db->order_by($order,'ASC');
        $this->db->where($criteres);
        
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getListO($table,$criteres = array(),$order,$order_value) {
        $this->db->order_by($order, $order_value);
        $this->db->where($criteres);
        
        $query = $this->db->get($table);
        return $query->result_array();
    }


    function checkvalue($table, $criteres) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
        {
           return true ;
        }
        else{
    return false;
    }
    }



    function getOne($table, $criteres) {

        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }

   function delete($table,$criteres){
        $this->db->where($criteres);
        $query = $this->db->delete($table);
        return ($query) ? true : false;
    }



    function record_count($table)
    {
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }


    function record_countsome($table, $criteres)
    {
      $this->db->where($criteres);
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }



        function getListOrder($table,$criteres)
    {
        $this->db->order_by($criteres);
      $query= $this->db->get($table);
      if($query)
      {
          return $query->result_array();
      }
    }


    
	



     function fetch_table($table,$limit,$start,$order,$ordervalue)
    {
     $this->db->limit($limit,$start);
     $this->db->order_by($order,$ordervalue);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->result_array();
       }   
    }




        function getToutList($requete) {
        //$this->db->where($criteres);
       $query = $this->db->query($requete);
       $result=$query->result_array();
        return $result;
    }
    
    function checkvalue1($table,$champ, $criteres) {
        
        $this->db->where($champ, $criteres);
        $query = $this->db->get($table);

        if ($query) {
            return $query->row_array();
        }
       
    }

    public function Listdelegationpersonnel(){
    $data = array();
    $this->db->select('pd.ID_DELEGATION');
    
    $this->db->from('personnel_delegation pd');

    $this->db->group_by('pd.ID_DELEGATION');
    $query=$this->db->get();
       
    if ($query) {
            return $query->result_array();
        }
    }

    function ListOrder_personnel($table,$condition= array(),$criteres)
    {
        $this->db->where($condition);
        $this->db->order_by($criteres);
      $query= $this->db->get($table);
      if($query)
      {
          return $query->result_array();
      }
    }

public function get_elements($criterepieces=array()){

      /* $this->db->select('NOM_ELEMENT');
       
      $this->db->group_by('NOM_ELEMENT');
      $query=$this->db->get($table);
      return $query->result_array()  ;*/
      
  $this->db->select("*");
  $this->db->from('element e');
  $this->db->join('elements_piece ep', 'ep.CODE_ELEMENT = e.CODE_ELEMENT');
   $this->db->where("CODE_PIECE",$criterepieces);
  $query = $this->db->get();
  return $query->result_array();
 
       }
    public function get_ones($table, $champ, $value) {
        $this->db->where($champ, $value);
        $query = $this->db->get($table);
        if ($query) {
            return $query->result_array();
        }
    }

//fonction ghislain
function getList_distinct_some($table,$distinct=array(), $value) {
        $this->db->where($value);
        $this->db->select($distinct);
        $query = $this->db->get($table);
        return $query->result_array();
    }


function fetch_table_new($table,$limit,$start,$order,$ordervalue,$criteres)
    {
     $this->db->where($criteres);
     $this->db->limit($limit,$start);
     $this->db->order_by($order,$ordervalue);
     $query= $this->db->get($table);
     
      if($query)
       {
           return $query->row_array();
       }   
    }



    //fonction permettant de se connecter
function login($email,$password)
    {
   $this->db->where('EMAIL_PRENEUR',$email);
   $this->db->where('PASSWORD',$password);
   $query=$this->db->get('preneur');

  if($query->num_rows()==1)
   {
      return $query->row();
    }
  else{
      return false;
      }
   }


   function getListOrdered($table,$order=array(),$criteres = array()) {
        $this->db->where($criteres);
        $this->db->order_by($order,"ASC");
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function record_countsome22($table, $criteres=array(),$cond=array())
    {
      $this->db->where($criteres);
      $this->db->where($cond);
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }
    //alain
     function getCond_distinct($table,$distinct=array(),$where=array(),$where2=array()) {
        $this->db->select($distinct);
        $this->db->where($where);
        $this->db->where($where2);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    
    function getsomme($table, $column=array(), $cond=array(),$cond2=array())
    {
       $this->db->select($column);
       $this->db->where($cond);
       $this->db->where($cond2);
       $query = $this->db->get($table);
       return $query->row_array();
    }  

    function getSommes($table, $criteres = array(),$reste) {
        $this->db->select_sum($reste);
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function getListDistinct($table,$criteres = array(),$distinctions) {
        $this->db->select("DISTINCT($distinctions)");
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }


   function getDate($table, $whereDate,$criteres = array()) {
        $this->db->where($whereDate);
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function querysql($sql){
    $query=$this->db->query($sql);
    // return $query->result_array();
    return $query->row_array();

  }


function getOneLimit($table,$limit,$start,$order,$ordervalue,$criteres = array())
    {
     $this->db->where($criteres);
     $this->db->limit($limit,$start);
     $this->db->order_by($order,$ordervalue);
     $query= $this->db->get($table);
     
      if($query)
       {
           // return $query->result_array();
           return $query->row_array();
       }   
    }
    
}