<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    ####tableau de bord des beneficiaire paeej
    #### fait par NIYONGABO Emery modifié MANIRATUNGA ERIC 
    ### emery@mediabox.bi,maniratunga.eric@mediabox.bi
    ### le 20/02/2022
    class Dashboard_General_Citoyen extends CI_Controller {

    public function __construct()
    {
      parent::__construct();    
      $this->load->helper('form');    
      $this->load->library('table');   
      $this->load->library('form_validation');   
      $this->load->model('Model');
    }

    #### fonction pour les couleurs des rapports
    public function getcolor() 
    {
      $chars = 'ABCDEF0123456789';
      $color = '#';
      for ( $i= 0; $i < 6; $i++ ) {
      $color.= $chars[rand(0, strlen($chars) -1)];
    }
      return $color;
    }

    #### appel du filtre dans la function index,
    public function index(){

      $provinces=$this->Model->getRequete('SELECT provinces.PROVINCE_ID,provinces.PROVINCE_NAME FROM provinces ORDER BY PROVINCE_NAME');
      $data['provinces']=$provinces;
      $FORMATION_ID=$this->input->post('FORMATION_ID');
      $PROVINCE_ID=$this->input->post('PROVINCE_ID');
      $STATUT=$this->input->post('STATUT');
      $data['provinces']=$provinces;
      $data['PROVINCE_ID']=$PROVINCE_ID;
      $data['STATUT']=$STATUT;
      #### appel de la vue
      $this->load->view('Dashboard_General_Citoyen_View',$data);
    }

    ###fonction pour les rapports et  les filtre sans reloard
    public function get_rapport(){ 

        ###declaration des differentes variables
        $STATUT=$this->input->post('STATUT');
        $PROVINCE_ID=$this->input->post('PROVINCE_ID');
        $COMMUNE_ID=$this->input->post('COMMUNE_ID');
        $ZONE_ID=$this->input->post('ZONE_ID');
        $COLLINE_ID=$this->input->post('COLLINE_ID');
        $date1=$this->input->post('DATE1');
        $date2=$this->input->post('DATE2');
        $criteres="";
        $critere21="";
        $DateRApport="";
        $DateDetail="";
        if(empty($date1) AND empty($date2) )
         {
         $DateRApport="Le ".date('d-m-Y'); 
         $DateDetail=" ";
         }
        if(!empty($date1) AND !empty($date2) )
         {
          $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
          $DateRApport="Du ".date('d/m/Y',strtotime($date1))." Au ".date('d/m/Y',strtotime($date2))."";
          $DateDetail=": Du ".date('d/m/Y',strtotime($date1))." Au ".date('d/m/Y',strtotime($date2))."";
          }
        if(empty($date1) AND !empty($date2) )
         {
        $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date2."'";
        $DateRApport="Le ".date('d/m/Y',strtotime($date2)).""; 
        $DateDetail=": Le ".date('d/m/Y',strtotime($date2)).""; 
         }
        if(!empty($date1) AND empty($date2) )
        {
        $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date1."'";
        $DateRApport="Le ".date('d/m/Y',strtotime($date1)).""; 
        $DateDetail=": Le ".date('d/m/Y',strtotime($date1)).""; 
        }

        $provinces=$this->Model->getRequete('SELECT provinces.PROVINCE_ID,provinces.PROVINCE_NAME FROM provinces ORDER BY PROVINCE_NAME');
        $cond="";
        if(!empty($PROVINCE_ID))
           {
          $communes="SELECT COMMUNE_ID,COMMUNE_NAME FROM communes WHERE PROVINCE_ID=".$PROVINCE_ID;
            $communes=$this->Model->getRequete($communes);
            $cond.=" AND citoyen.PROVINCE_ID=".$PROVINCE_ID;
          if(!empty($COMMUNE_ID))
          {
          $zones="SELECT ZONE_ID,ZONE_NAME FROM zones WHERE COMMUNE_ID=".$COMMUNE_ID;
          $zones=$this->Model->getRequete($zones);
          $cond.=" AND citoyen.COMMUNE_ID=".$COMMUNE_ID; 
            if(!empty($ZONE_ID))
            {
            $collines="SELECT COLLINE_ID,COLLINE_NAME FROM collines WHERE ZONE_ID=".$ZONE_ID;
             $collines=$this->Model->getRequete($collines);
             $cond.=" AND citoyen.ZONE_ID=".$ZONE_ID;
              if(!empty($COLLINE_ID))
              {
              $cond.=" AND citoyen.COLLINE_ID=".$COLLINE_ID; 
              }
           }
          }
        }
        $ben_sex=$this->Model->getRequete('SELECT sexe.DESCR AS NAME,sexe.SEXE_ID AS ID,COUNT(citoyen.CITOYEN_ID) AS NBRE FROM sexe LEFT JOIN citoyen ON sexe.SEXE_ID=citoyen.SEXE_ID WHERE 1  '.$cond.' '.$criteres.' '.$critere21.'  GROUP BY  NAME,ID ORDER BY NBRE DESC');

        $tsex=$this->Model->getRequeteOne('SELECT COUNT(citoyen.CITOYEN_ID) AS NBRE FROM sexe LEFT JOIN citoyen ON sexe.SEXE_ID=citoyen.SEXE_ID WHERE 1  '.$cond.' '.$criteres.' '.$critere21.'');

          $total_sex=0;
          $donnees_sex='';
          $psex=0;
          foreach ($ben_sex as $value)
            {
            $color=$this->getcolor();
            $pourcent=0;
            if ($tsex['NBRE']>0) {
             $pourcent=($value['NBRE']/$tsex['NBRE'])*100;
              }
              $psex=number_format($pourcent,2,'.',' ');
              $nb = (!empty($value['ID'])) ? $value['ID'] : "0" ;
              $somme1=($value['NBRE']>0) ? $value['NBRE'] : "0" ;
              $total_sex=$total_sex+$value['NBRE'];
              $name = (!empty($value['NAME'])) ? $value['NAME'] : "Autres" ;
              $donnees_sex.="{name:'".str_replace("'","\'", $name)." : ".$somme1."', y:". $psex.",color:'".$color."',key2:1,key:'". $nb."'},";

              }
        ### rapport des beneficiaires  par etat civil
        $ben_etat=$this->Model->getRequete('SELECT citoyen_statut_matrimonial.DESCRIPTION AS NAME,citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID AS ID,COUNT(citoyen.CITOYEN_ID) AS NBRE FROM `citoyen_statut_matrimonial` LEFT JOIN citoyen ON citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID=citoyen.STATUT_MATRIMONIAL_ID WHERE 1 '.$cond.' '.$criteres.' '.$critere21.'  GROUP BY  NAME,ID ORDER BY NBRE DESC');

        $tetat=$this->Model->getRequeteOne('SELECT COUNT(citoyen.CITOYEN_ID) AS NBRE  FROM `citoyen_statut_matrimonial` LEFT JOIN citoyen ON citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID=citoyen.STATUT_MATRIMONIAL_ID WHERE 1  '.$cond.' '.$criteres.' '.$critere21.'');


            $categorie_etat="";
            $donnees_etat="";
            $total_etat=0;
            foreach($ben_etat as $key)
            {
              $color=$this->getcolor();
              $categorie_etat.="'";
              $somme1=($key['NBRE']>0) ? $key['NBRE'] : "0" ;
              $key['ID']=($key['ID']>0) ? $key['ID']: "0" ;
              $name = (!empty($key['NAME'])) ? $key['NAME'] : "Autres" ;
              $rappel=str_replace("'", "\'", $name);
              $pourcent=0;
              if ($tetat['NBRE']>0)
              {
                $pourcent=($key['NBRE']/$tetat['NBRE'])*100;
              }

                $petat=number_format($pourcent,2,'.',' ');
                $categorie_etat.= $rappel."',";
                $donnees_etat.="{name:'".str_replace("'","\'", $name)." : (".$somme1.")',y:".$somme1.",color:'".$color."',key:". $key['ID']."},";
              $total_etat=$total_etat+$key['NBRE'];
            }

        ###rapport de demande par tranche d'age
        $annee_naiss= array('0-10 ans'=>'0 AND 10', '11-20 ans'=>'11 AND 20', '21-30 ans'=>'21 AND 30', '31-40 ans'=>'31 AND 40', '41-50 ans'=>'41 AND 50', '51-60 ans'=>'51 AND 60', '61 et plus'=>'61 AND 100');

          $traite_naiss_categorie=" ";
          $traite_naiss_categorie_total=0;

        $genaiss_pour = $this->Model->getRequeteOne("SELECT COUNT(`CITOYEN_ID`) AS NBRE FROM  citoyen WHERE 1 ".$cond." ".$criteres." ".$critere21." ");

        foreach ($annee_naiss as $key => $value){ 

        $genaiss = $this->Model->getRequeteOne("SELECT COUNT(`CITOYEN_ID`) AS NBRE FROM citoyen WHERE DATE_FORMAT(now(),'%Y')-date_format(citoyen.`CITOYEN_DATE_NAISSANCE`,'%Y') BETWEEN ".$value." ".$cond." ".$criteres." ".$critere21." ");

            $pourcent_naiss=0;
            if ($genaiss_pour['NBRE']>0) {

            $pourcent_naiss=($genaiss['NBRE']/$genaiss_pour['NBRE'])*100;
            } 
            $pourcent_ss=number_format($pourcent_naiss,2,'.',' ');
            $nbr = !empty($genaiss['NBRE']) ? $genaiss['NBRE'] : 0 ;
            $traite_naiss_categorie.="{name:'".$key."', y:".$nbr.",key:'".$value."'},";
            $traite_naiss_categorie_total=$traite_naiss_categorie_total+$genaiss['NBRE'];
            }
        ### rapport des benefiaires par profession
        $cni_profession=$this->Model->getRequete('SELECT `cni_profession`.`PROFESSION_ID` as ID,`cni_profession`.`DESCRIPTION` as NAME,COUNT(`CITOYEN_ID`) as NBRE FROM `cni_profession` LEFT JOIN citoyen on citoyen.FONCTION_ID=cni_profession.PROFESSION_ID WHERE 1 '.$cond.' '.$critere21.' GROUP BY ID,NAME ORDER BY NBRE DESC');

        $tprofession=$this->Model->getRequeteOne('SELECT COUNT(citoyen.FONCTION_ID) AS NBRE  FROM `cni_profession` LEFT JOIN citoyen ON cni_profession.PROFESSION_ID=citoyen.FONCTION_ID WHERE 1  '.$cond.' '.$critere21.' ');

          $categorie10="";
          $donnees_profession="";
          $total_profession=0;
          foreach ($cni_profession as $key)
          {
            $color=$this->getcolor();
            $categorie10.="'";
            $somme1=($key['NBRE']>0) ? $key['NBRE'] : "0" ;
            $key['ID']=($key['ID']>0) ? $key['ID']: "0" ;
            $name = (!empty($key['NAME'])) ? $key['NAME'] : "Autres" ;
            $rappel=str_replace("'", "\'", $name);
            $categorie10.= $rappel."',";
            $donnees_profession.="{name:'".str_replace("'","\'", $name)." : (".$somme1.")',y:".$somme1.",color:'".$color."',key:". $key['ID']."},";
            $total_profession=$total_profession+$key['NBRE'];

          }


### appel des script highchart
$rapp="<script type=\"text/javascript\">
Highcharts.chart('container',{
chart: {
type: 'pie',

},
title: {
text: '<b>Citoyen par sexe</b>',

},

subtitle: {
text:'<b>".$DateRApport."<br> Total=".$total_sex."</b>'
},
accessibility: {
point: {
valueSuffix: ''
}
},
tooltip: {
pointFormat: '{series.name}: <b>{point.percentage:,1f}</b>'
},

plotOptions: {
pie: {

cursor:'pointer',
point:{
events: {
click: function()
{    
$(\"#titre\").html(\"LISTES DES CITOYENS".$DateDetail."\");
$(\"#myModal\").modal();
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
  url:\"".base_url('dashboard/Dashboard_General_Citoyen/detail_sexe')."\",
  type:\"POST\",
  data:{
  key:this.key,
  PROVINCE_ID:$('#PROVINCE_ID').val(),
  COMMUNE_ID:$('#COMMUNE_ID').val(),
  ZONE_ID:$('#ZONE_ID').val(), 
  COLLINE_ID:$('#COLLINE_ID').val(), 
  STATUT:$('#STATUT').val(),
  FORMATION_ID:$('#FORMATION_ID').val(), 
  DATE1 : $('#DATE1').val(),
  DATE2 : $('#DATE2').val(),
  }
  },
  lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
  pageLength: 10,
  \"columnDefs\":[{
      \"targets\":[],
      \"orderable\":false
      }],
      dom: 'Bfrtlip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
           ],
      language: {
          \"sProcessing\":     \"Traitement en cours...\",
          \"sSearch\":         \"Rechercher&nbsp;:\",
          \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
          \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
          \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
          \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
          \"sInfoPostFix\":    \"\",
          \"sLoadingRecords\": \"Chargement en cours...\",
          \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
          \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
          \"oPaginate\": {
              \"sFirst\":      \"Premier\",
              \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
              \"sNext\":       \"Suivant\",
              \"sLast\":       \"Dernier\"
              },
              \"oAria\": {
                  \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                  \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
              }
          }

          });

}
}
},

}
},

credits: {
enabled: true,
href: \"\",
text: \"\"
},      
series: [{
name: 'Citoyen',
data:   [".$donnees_sex."]

}]
});
</script>";




$rapp1="<script type=\"text/javascript\">
Highcharts.chart('container1', {
chart: {
type: 'bar'
},

title: {
text: '<b>Citoyen par état civil</b>'
},
subtitle: {
text: '<b>".$DateRApport."<br> Total</b>:".$total_etat."</b>'
},
xAxis: {
categories: [".$categorie_etat."],
crosshair: true
},
yAxis: {
allowDecimals: false,
min: 0,
title: {
text: ''
}
},
tooltip: {
formatter: function () {
return 
this.series.name;
}
},

tooltip: {
shared: true
},
plotOptions: {
bar: {
cursor:'pointer',
point:{
events: {
click: function()
{  
$(\"#titre\").html(\"LISTES DES CITOYENS".$DateDetail."\");
    
$(\"#myModal\").modal();
   
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_General_Citoyen/detail_civil')."\",
type:\"POST\",
data:{
  key:this.key,
  PROVINCE_ID:$('#PROVINCE_ID').val(),
  COMMUNE_ID:$('#COMMUNE_ID').val(),
  ZONE_ID:$('#ZONE_ID').val(),
  COLLINE_ID:$('#COLLINE_ID').val(),
  STATUT:$('#STATUT').val(),
  FORMATION_ID:$('#FORMATION_ID').val(),
  DATE1 : $('#DATE1').val(),
  DATE2 : $('#DATE2').val(),
 }
 },
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
\"targets\":[],
\"orderable\":false
 }],

dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
                       ],
language: {
  \"sProcessing\":     \"Traitement en cours...\",
  \"sSearch\":         \"Rechercher&nbsp;:\",
  \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
  \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
  \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
  \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
  \"sInfoPostFix\":    \"\",
  \"sLoadingRecords\": \"Chargement en cours...\",
  \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
  \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
  \"oPaginate\": {
    \"sFirst\":      \"Premier\",
    \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
    \"sNext\":       \"Suivant\",
    \"sLast\":       \"Dernier\"
  },
  \"oAria\": {
    \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
    \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
  }
}

});

}
}
},
dataLabels: {
enabled: true,
format: '{point.y:,2f}'
},
showInLegend: true
}
}, 
credits: {
enabled: true,
href: \"\",
text: \"\"
},


yAxis: {
title: {
text: ' '
}
},

series: [{
name: 'Citoyen',
color: 'green',
data: [".$donnees_etat."]
}]

});
</script>";

       
$rapp2="<script type=\"text/javascript\">

Highcharts.chart('container2', {
chart: {
type: 'pyramid'
},
title: {
text: '<b>Citoyen par tranche d\'âge </b>',
x: -20
},

subtitle:
{    
text:'<b>".$DateRApport."<br>Total:<b>".$traite_naiss_categorie_total."</b>'
},

plotOptions: {
pyramid: {
pointPadding: 0.2,
borderWidth: 0,
cursor:'pointer',
point:{
events: {
click: function()
{

$(\"#myModalAGE\").modal();
$(\"#titreAGE\").html(\"BENEFICIAIRES PAR TRANCHE D'AGE QUI ONT POSTULE".$DateDetail."\");
var row_count ='1000000';
$(\"#mytableAGE\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
  url:\"".base_url('index.php/dashboard/Dashboard_General_Citoyen/detail_age')."\",
  type:\"POST\",
  data:{
      key:this.key,
      PROVINCE_ID:$('#PROVINCE_ID').val(),
      COMMUNE_ID:$('#COMMUNE_ID').val(),
      ZONE_ID:$('#ZONE_ID').val(), 
      COLLINE_ID:$('#COLLINE_ID').val(), 
      STATUT:$('#STATUT').val(),
      FORMATION_ID:$('#FORMATION_ID').val(),
      DATE1 : $('#DATE1').val(),
      DATE2 : $('#DATE2').val(),
       }
     },
  lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
  pageLength: 10,
  \"columnDefs\":[{
      \"targets\":[],
      \"orderable\":false
      }],
      dom: 'Bfrtlip',
       buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
          ],
      language: {
          \"sProcessing\":     \"Traitement en cours...\",
          \"sSearch\":         \"Rechercher&nbsp;:\",
          \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
          \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
          \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
          \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
          \"sInfoPostFix\":    \"\",
          \"sLoadingRecords\": \"Chargement en cours...\",
          \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
          \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
          \"oPaginate\": {
              \"sFirst\":      \"Premier\",
              \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
              \"sNext\":       \"Suivant\",
              \"sLast\":       \"Dernier\"
              },
              \"oAria\": {
                  \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
                  \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
              }
          }

          });
       }
      }
    },
  dataLabels:{
      enabled: true,
      format: '<b>{point.name}</b> ({point.y:,.0f})',
      softConnector: true
      },
      center: ['40%', '50%'],
      width: '80%',

      showInLegend: true

  }
  }, 
  credits: {
    enabled: true,
    href: \"\",
    text: \"\"
    },

series: [{
name: 'Bénéficiaires',
data: [".$traite_naiss_categorie."]
}],
responsive: {
rules: [{
condition: {
maxWidth: 200
},
chartOptions: {
 plotOptions: {
    pyramid: {
        pointPadding: 0.2,
        borderWidth: 0,
        cursor:'pointer',

        dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b> ({point.y:,2f})',
            softConnector: true
            },
            center: ['40%', '50%'],
            width: '80%',

            showInLegend: true
        }
        }, 
        credits: {
          enabled: true,
          href: \"\",
          text: \"Mediabox\"
          },
          center: ['5%', '40%'],
          width: '50%'
      }

      }]
  }
  });
  </script>
";



$rapp3="<script type=\"text/javascript\">
Highcharts.chart('container3', {
chart: {
type: 'column'
  },

title:{
text: '<b>Citoyen par profession </b>'
     },
subtitle: {
text: '<b>".$DateRApport."<br> Total</b>:".$total_profession."</b>'
},

xAxis: {
categories: [".$categorie10."],
crosshair: true
},

yAxis: {
allowDecimals: false,
min: 0,
title: {
text: ''
}
},

tooltip: {
formatter: function () {
return '<b>' + this.x + '</b><br/>' +
this.series.name + ': ' + this.y + '<br/>' +
'Total: ' + this.point.stackTotal;
}
},

tooltip: {
shared: true
},
plotOptions: {
  column: {
cursor:'pointer',
point:{
events: {
click: function()
{  
$(\"#titre\").html(\"LISTES DES CITOYENS ".$DateDetail."\");
      
$(\"#myModal\").modal();
      
var row_count ='1000000';
$(\"#mytable\").DataTable({
\"processing\":true,
\"serverSide\":true,
\"bDestroy\": true,
\"oreder\":[],
\"ajax\":{
url:\"".base_url('dashboard/Dashboard_General_Citoyen/detail_profession')."\",
type:\"POST\",
data:{
    key:this.key,
    PROVINCE_ID:$('#PROVINCE_ID').val(),
    COMMUNE_ID:$('#COMMUNE_ID').val(),
    ZONE_ID:$('#ZONE_ID').val(),
    COLLINE_ID:$('#COLLINE_ID').val(),
    STATUT:$('#STATUT').val(),
    FORMATION_ID:$('#FORMATION_ID').val(),
    DATE1 : $('#DATE1').val(),
    DATE2 : $('#DATE2').val(),
   }
   },
lengthMenu: [[10,50, 100, row_count], [10,50, 100, \"All\"]],
pageLength: 10,
\"columnDefs\":[{
 \"targets\":[],
 \"orderable\":false
   }],

dom: 'Bfrtlip',
buttons: ['copy', 'csv', 'excel', 'pdf', 'print'
                         ],
language: {
    \"sProcessing\":     \"Traitement en cours...\",
    \"sSearch\":         \"Rechercher&nbsp;:\",
    \"sLengthMenu\":     \"Afficher _MENU_ &eacute;l&eacute;ments\",
    \"sInfo\":           \"Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments\",
    \"sInfoEmpty\":      \"Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment\",
    \"sInfoFiltered\":   \"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)\",
    \"sInfoPostFix\":    \"\",
    \"sLoadingRecords\": \"Chargement en cours...\",
    \"sZeroRecords\":    \"Aucun &eacute;l&eacute;ment &agrave; afficher\",
    \"sEmptyTable\":     \"Aucune donn&eacute;e disponible dans le tableau\",
    \"oPaginate\": {
      \"sFirst\":      \"Premier\",
      \"sPrevious\":   \"Pr&eacute;c&eacute;dent\",
      \"sNext\":       \"Suivant\",
      \"sLast\":       \"Dernier\"
    },
    \"oAria\": {
      \"sSortAscending\":  \": activer pour trier la colonne par ordre croissant\",
      \"sSortDescending\": \": activer pour trier la colonne par ordre d&eacute;croissant\"
    }
}
  
});
}
}
},
dataLabels: {
enabled: true,
format: '{point.y:,2f} '
},
showInLegend: true
}
}, 
credits: {
enabled: true,
href: \"\",
text: \"\"
},

yAxis: 
{
title: 
{
text: ' '
}
},
series: [{
name: 'Citoyen',
color: 'green',
data: [".$donnees_profession."]
}]
});
</script>";



     $comm= '<option selected="" disabled="">sélectionner</option>';
     $cd= '<option selected="" disabled="">sélectionner</option>';
     $zon= '<option selected="" disabled="">sélectionner</option>';
     $col= '<option selected="" disabled="">sélectionner</option>';
        if (!empty($PROVINCE_ID)) {

            $critere['PROVINCE_ID'] = $PROVINCE_ID;

            $communes = $this->Model->getList('communes', $critere);


            foreach ($communes as $commun) {
                if (!empty($COMMUNE_ID)) {

                    if ($COMMUNE_ID==$commun['COMMUNE_ID']) {
                        $comm.= "<option value ='".$commun['COMMUNE_ID']."' selected>".$commun['COMMUNE_NAME']."</option>";
                    }
                    else{
                        $comm.= "<option value ='".$commun['COMMUNE_ID']."'>".$commun['COMMUNE_NAME']."</option>";
                    }

                }else{
                    $comm.= "<option value ='".$commun['COMMUNE_ID']."'>".$commun['COMMUNE_NAME']."</option>";
                }
            }
        }

        if (!empty($COMMUNE_ID)) {
            $critere2['COMMUNE_ID'] = $COMMUNE_ID;
            $zones = $this->Model->getList('zones', $critere2);

            foreach ($zones as $zo) {
                if (!empty($ZONE_ID)) {
                    if ($ZONE_ID==$zo['ZONE_ID']) {
                        $zon.= "<option value ='".$zo['ZONE_ID']."' selected>".$zo['ZONE_NAME']."</option>";
                    }
                    else{
                        $zon.= "<option value ='".$zo['ZONE_ID']."'>".$zo['ZONE_NAME']."</option>";
                    }

                }else{
                    $zon.= "<option value ='".$zo['ZONE_ID']."'>".$zo['ZONE_NAME']."</option>";
                } 
            }

        }

        if (!empty($COMMUNE_ID)) {
            $critere2['COMMUNE_ID'] = $COMMUNE_ID;

        }

        if (!empty($ZONE_ID)) {
            $critere1['ZONE_ID'] = $ZONE_ID;
            $collines = $this->Model->getList('collines', $critere1);

            foreach ($collines as $coll) {
                if (!empty($COLLINE_ID)) {
                    if ($COLLINE_ID==$coll['COLLINE_ID']) {
                        $col.= "<option value ='".$coll['COLLINE_ID']."' selected>".$coll['COLLINE_NAME']."</option>";
                    }
                    else{
                        $col.= "<option value ='".$coll['COLLINE_ID']."'>".$coll['COLLINE_NAME']."</option>";
                    }

                }else{
                    $col.= "<option value ='".$coll['COLLINE_ID']."'>".$coll['COLLINE_NAME']."</option>";
                } 
            }

        }
    echo json_encode(array('rapp'=>$rapp,'rapp1'=>$rapp1,'rapp2'=>$rapp2,'rapp3'=>$rapp3,'comm'=>$comm,'zon'=>$zon,'col'=>$col));
        }

        //detail du rapport des acteurs par sexe
        function detail_sexe(){
          $KEY=$this->input->post('key');
          $PROVINCE_ID=$this->input->post('PROVINCE_ID');
          $COMMUNE_ID=$this->input->post('COMMUNE_ID');
          $ZONE_ID=$this->input->post('ZONE_ID');
          $COLLINE_ID=$this->input->post('COLLINE_ID');
          $STATUT=$this->input->post('STATUT');
          $FORMATION_ID=$this->input->post('FORMATION_ID');
          $date1=$this->input->post('DATE1');
          $date2=$this->input->post('DATE2');
          $break=explode(".",$KEY);
          $ID=$KEY;
          $criteres1='';
          $criteres='';
          $critere21='';

          $cond='';
          $cond1='';
          $type1=" ";

          if($PROVINCE_ID>0){
              $criteres1=" AND citoyen.PROVINCE_ID=".$PROVINCE_ID;
              if($COMMUNE_ID>0){
                  $criteres1.=" AND citoyen.COMMUNE_ID=".$COMMUNE_ID;
                  if($ZONE_ID>0){
                      $criteres1.=" AND citoyen.ZONE_ID=".$ZONE_ID;
                      if($COLLINE_ID>0){
                          $criteres1.=" AND citoyen.COLLINE_ID=".$COLLINE_ID;

                      }
                  }

              }
          }
           if(!empty($date1) AND !empty($date2) )
              {
                
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
              }
              if(empty($date1) AND !empty($date2) )
              {
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date2."'";
              }
              if(!empty($date1) AND empty($date2) )
              {
               $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date1."'";
              }

            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

            $query_principal="SELECT `CITOYEN_NOM`,`CITOYEN_PRENOM`,citoyen_statut_matrimonial.DESCRIPTION as civil,date_format(citoyen.CITOYEN_DATE_NAISSANCE,'%d-%m-%Y') as CITOYEN_DATE_NAISSANCE,sexe.DESCR,provinces.PROVINCE_NAME,communes.COMMUNE_NAME,zones.ZONE_NAME,collines.COLLINE_NAME FROM `citoyen` LEFT JOIN provinces ON provinces.PROVINCE_ID=citoyen.PROVINCE_ID LEFT  JOIN communes ON communes.COMMUNE_ID=citoyen.COMMUNE_ID LEFT  JOIN zones ON zones.ZONE_ID=citoyen.ZONE_ID LEFT  JOIN collines ON collines.COLLINE_ID=citoyen.COLLINE_ID LEFT JOIN citoyen_statut_matrimonial ON citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID=citoyen.STATUT_MATRIMONIAL_ID  LEFT JOIN  sexe ON sexe.SEXE_ID=citoyen.SEXE_ID WHERE 1 ".$criteres1." ".$criteres." ".$critere21." ";
            $limit='LIMIT 0,10';
            if($_POST['length'] != -1){
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
            $order_by='';
            if($_POST['order']['0']['column']!=0){
                $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
            }

            $search = !empty($_POST['search']['value']) ? (" AND ( `CITOYEN_PRENOM` LIKE '%$var_search%' OR `DESCRIPTION` LIKE '%$var_search%' OR citoyen.`CITOYEN_NOM` LIKE '%$var_search%') ") : '';

            $critaire = ($ID==0) ? ' and (citoyen.SEXE_ID is null OR citoyen.SEXE_ID=0 OR citoyen.SEXE_ID>2 )' :'AND  citoyen.SEXE_ID='.$ID.'' ;   

            $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
            $query_filter=$query_principal.'  '.$critaire.' '.$search;
            $fetch_data = $this->Model->datatable($query_secondaire);
            $u=0;
            $data = array();
            foreach ($fetch_data as $row)  {
                $u++;
                $beneficiaire=array();
                $beneficiaire[] = $u;
                $beneficiaire[] =$row->CITOYEN_NOM;
                $beneficiaire[] =$row->CITOYEN_PRENOM;
                $beneficiaire[] =$row->DESCR;
                $beneficiaire[] =$row->civil;
                $beneficiaire[] =$row->CITOYEN_DATE_NAISSANCE;
                $beneficiaire[] =$row->PROVINCE_NAME;
                $beneficiaire[] =$row->COMMUNE_NAME;
                $beneficiaire[] =$row->ZONE_NAME;
                $beneficiaire[] =$row->COLLINE_NAME;
                $data[] = $beneficiaire;
            }
            $output = array(
                "draw" => intval($_POST['draw']),
                "recordsTotal" =>$this->Model->all_data($query_principal),
                "recordsFiltered" => $this->Model->filtrer($query_filter),
                "data" => $data
            );
            echo json_encode($output);
        }

        //detail du rapport des acteurs par sexe
        function detail_civil(){
          $KEY=$this->input->post('key');
          $PROVINCE_ID=$this->input->post('PROVINCE_ID');
          $COMMUNE_ID=$this->input->post('COMMUNE_ID');
          $ZONE_ID=$this->input->post('ZONE_ID');
          $COLLINE_ID=$this->input->post('COLLINE_ID');
          $STATUT=$this->input->post('STATUT');
          $FORMATION_ID=$this->input->post('FORMATION_ID');
          $date1=$this->input->post('DATE1');
          $date2=$this->input->post('DATE2');
          $break=explode(".",$KEY);
          $ID=$KEY;
          $criteres1='';
          $criteres='';
          $critere21='';

          $cond='';
          $cond1='';
          $type1=" ";

          if($PROVINCE_ID>0){
              $criteres1=" AND citoyen.PROVINCE_ID=".$PROVINCE_ID;
              if($COMMUNE_ID>0){
                  $criteres1.=" AND citoyen.COMMUNE_ID=".$COMMUNE_ID;
                  if($ZONE_ID>0){
                      $criteres1.=" AND citoyen.ZONE_ID=".$ZONE_ID;
                      if($COLLINE_ID>0){
                          $criteres1.=" AND citoyen.COLLINE_ID=".$COLLINE_ID;

                      }
                  }

              }
          }
           if(!empty($date1) AND !empty($date2) )
              {
                
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
              }
              if(empty($date1) AND !empty($date2) )
              {
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date2."'";
              }
              if(!empty($date1) AND empty($date2) )
              {
               $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date1."'";
              }

            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

            $query_principal="SELECT `CITOYEN_NOM`,`CITOYEN_PRENOM`,citoyen_statut_matrimonial.DESCRIPTION as civil,date_format(citoyen.CITOYEN_DATE_NAISSANCE,'%d-%m-%Y') as CITOYEN_DATE_NAISSANCE,sexe.DESCR,provinces.PROVINCE_NAME,communes.COMMUNE_NAME,zones.ZONE_NAME,collines.COLLINE_NAME FROM `citoyen` LEFT JOIN provinces ON provinces.PROVINCE_ID=citoyen.PROVINCE_ID LEFT  JOIN communes ON communes.COMMUNE_ID=citoyen.COMMUNE_ID LEFT  JOIN zones ON zones.ZONE_ID=citoyen.ZONE_ID LEFT  JOIN collines ON collines.COLLINE_ID=citoyen.COLLINE_ID LEFT JOIN citoyen_statut_matrimonial ON citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID=citoyen.STATUT_MATRIMONIAL_ID  LEFT JOIN  sexe ON sexe.SEXE_ID=citoyen.SEXE_ID WHERE 1 ".$criteres1." ".$criteres." ".$critere21." ";
            $limit='LIMIT 0,10';
            if($_POST['length'] != -1){
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
            $order_by='';
            if($_POST['order']['0']['column']!=0){
                $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
            }

            $search = !empty($_POST['search']['value']) ? (" AND ( `CITOYEN_PRENOM` LIKE '%$var_search%' OR `DESCRIPTION` LIKE '%$var_search%' OR citoyen.`CITOYEN_NOM` LIKE '%$var_search%') ") : '';

            $critaire = ($ID==0) ? ' and (citoyen.STATUT_MATRIMONIAL_ID is null)' :'AND  citoyen.STATUT_MATRIMONIAL_ID='.$ID.'' ;   

            $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
            $query_filter=$query_principal.'  '.$critaire.' '.$search;
            $fetch_data = $this->Model->datatable($query_secondaire);
            $u=0;
            $data = array();
            foreach ($fetch_data as $row)  {
                $u++;
                $beneficiaire=array();
                $beneficiaire[] = $u;
                $beneficiaire[] =$row->CITOYEN_NOM;
                $beneficiaire[] =$row->CITOYEN_PRENOM;
                $beneficiaire[] =$row->DESCR;
                $beneficiaire[] =$row->civil;
                $beneficiaire[] =$row->CITOYEN_DATE_NAISSANCE;
                $beneficiaire[] =$row->PROVINCE_NAME;
                $beneficiaire[] =$row->COMMUNE_NAME;
                $beneficiaire[] =$row->ZONE_NAME;
                $beneficiaire[] =$row->COLLINE_NAME;
                $data[] = $beneficiaire;
            }
            $output = array(
                "draw" => intval($_POST['draw']),
                "recordsTotal" =>$this->Model->all_data($query_principal),
                "recordsFiltered" => $this->Model->filtrer($query_filter),
                "data" => $data
            );
            echo json_encode($output);
        }



          function detail_profession(){
          $KEY=$this->input->post('key');
          $PROVINCE_ID=$this->input->post('PROVINCE_ID');
          $COMMUNE_ID=$this->input->post('COMMUNE_ID');
          $ZONE_ID=$this->input->post('ZONE_ID');
          $COLLINE_ID=$this->input->post('COLLINE_ID');
          $STATUT=$this->input->post('STATUT');
          $FORMATION_ID=$this->input->post('FORMATION_ID');
          $date1=$this->input->post('DATE1');
          $date2=$this->input->post('DATE2');
          $break=explode(".",$KEY);
          $ID=$KEY;
          $criteres1='';
          $criteres='';
          $critere21='';

          $cond='';
          $cond1='';
          $type1=" ";

          if($PROVINCE_ID>0){
              $criteres1=" AND citoyen.PROVINCE_ID=".$PROVINCE_ID;
              if($COMMUNE_ID>0){
                  $criteres1.=" AND citoyen.COMMUNE_ID=".$COMMUNE_ID;
                  if($ZONE_ID>0){
                      $criteres1.=" AND citoyen.ZONE_ID=".$ZONE_ID;
                      if($COLLINE_ID>0){
                          $criteres1.=" AND citoyen.COLLINE_ID=".$COLLINE_ID;

                      }
                  }

              }
          }
           if(!empty($date1) AND !empty($date2) )
              {
                
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d') BETWEEN '".$date1."' AND '".$date2."'" ;
              }
              if(empty($date1) AND !empty($date2) )
              {
                $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date2."'";
              }
              if(!empty($date1) AND empty($date2) )
              {
               $critere21=" AND date_format(citoyen.DATE_INSERTION,'%Y-%m-%d')='".$date1."'";
              }

            $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

            $query_principal="SELECT `CITOYEN_NOM`,`CITOYEN_PRENOM`,citoyen_statut_matrimonial.DESCRIPTION as civil,date_format(citoyen.CITOYEN_DATE_NAISSANCE,'%d-%m-%Y') as CITOYEN_DATE_NAISSANCE,sexe.DESCR,provinces.PROVINCE_NAME,communes.COMMUNE_NAME,zones.ZONE_NAME,collines.COLLINE_NAME FROM `citoyen` LEFT JOIN provinces ON provinces.PROVINCE_ID=citoyen.PROVINCE_ID LEFT  JOIN communes ON communes.COMMUNE_ID=citoyen.COMMUNE_ID LEFT  JOIN zones ON zones.ZONE_ID=citoyen.ZONE_ID LEFT  JOIN collines ON collines.COLLINE_ID=citoyen.COLLINE_ID LEFT JOIN citoyen_statut_matrimonial ON citoyen_statut_matrimonial.STATUT_MATRIMONIAL_ID=citoyen.STATUT_MATRIMONIAL_ID  LEFT JOIN  sexe ON sexe.SEXE_ID=citoyen.SEXE_ID WHERE 1 ".$criteres1." ".$criteres." ".$critere21." ";
            $limit='LIMIT 0,10';
            if($_POST['length'] != -1){
                $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
            }
            $order_by='';
            if($_POST['order']['0']['column']!=0){
                $order_by = isset($_POST['order']) ? ' ORDER BY '.$_POST['order']['0']['column'] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY NOM   DESC';
            }

            $search = !empty($_POST['search']['value']) ? (" AND ( `CITOYEN_PRENOM` LIKE '%$var_search%' OR `DESCRIPTION` LIKE '%$var_search%' OR citoyen.`CITOYEN_NOM` LIKE '%$var_search%') ") : '';

            $critaire = ($ID==0) ? ' and (citoyen.FONCTION_ID is null)' :'AND  citoyen.FONCTION_ID='.$ID.'' ;   

            $query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
            $query_filter=$query_principal.'  '.$critaire.' '.$search;
            $fetch_data = $this->Model->datatable($query_secondaire);
            $u=0;
            $data = array();
            foreach ($fetch_data as $row)  {
                $u++;
                $beneficiaire=array();
                $beneficiaire[] = $u;
                $beneficiaire[] =$row->CITOYEN_NOM;
                $beneficiaire[] =$row->CITOYEN_PRENOM;
                $beneficiaire[] =$row->DESCR;
                $beneficiaire[] =$row->civil;
                $beneficiaire[] =$row->CITOYEN_DATE_NAISSANCE;
                $beneficiaire[] =$row->PROVINCE_NAME;
                $beneficiaire[] =$row->COMMUNE_NAME;
                $beneficiaire[] =$row->ZONE_NAME;
                $beneficiaire[] =$row->COLLINE_NAME;
                $data[] = $beneficiaire;
            }
            $output = array(
                "draw" => intval($_POST['draw']),
                "recordsTotal" =>$this->Model->all_data($query_principal),
                "recordsFiltered" => $this->Model->filtrer($query_filter),
                "data" => $data
            );
            echo json_encode($output);
        }

        }