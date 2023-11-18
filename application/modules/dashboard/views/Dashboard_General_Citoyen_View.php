<!DOCTYPE html>
  <html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
  <head>
  	<?php include VIEWPATH.'includes/header.php'; ?> 
  	<!-- appel des scripts -->
  	<script src="https://code.highcharts.com/modules/exporting.js"></script>
  	<script src="https://code.highcharts.com/modules/pyramid3d.js"></script>
  	<script src="https://code.highcharts.com/modules/export-data.js"></script>
  	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
  	<script src="https://code.highcharts.com/highcharts-more.js"></script>
  	<script src="https://code.highcharts.com/modules/export-data.js"></script>
  	<script src="https://code.highcharts.com/modules/export-data.js"></script>
  	<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/variwide.js"></script>
  	<script src="https://code.highcharts.com/modules/funnel.js"></script>
  	<script src="https://code.highcharts.com/modules/export-data.js"></script>
  	<script src="https://code.highcharts.com/modules/item-series.js"></script>
  	<script src="https://code.highcharts.com/modules/export-data.js"></script>
  	<script src="https://code.highcharts.com/modules/pattern-fill.js"></script>
   <script src="https://code.highcharts.com/highcharts-3d.js"></script> 
   <script src="https://code.highcharts.com/modules/cylinder.js"></script>
   <script> 
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;  
            var yyyy = today.getFullYear();

            if(dd<10){
              dd='0'+dd
          } 
          if(mm<10){
              mm='0'+mm
          } 
          today = yyyy+'-'+mm+'-'+dd;
      </script>
     </head>
   <?php
$affect1="active";
$affect2="";

 ?>
<style type="text/css">
    .form-group{
        margin-top: 1px;
    }
</style>

<body>
    <div class="container-fluid" style="background-color: white">
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 5px" id="navp">
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <?php 
              $new = '';
              $list = 'active';
            ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Tableau de bord des citoyens</b></h4>  
                                </div>
                                </div>
              <div class="row">    
                <div class="col-md-3 col-sm-2">
                  <div class="form-group">
                    <LABEL>Province</LABEL>
                    <select class="form-control" onchange="submit_prov();get_rapport()" name="PROVINCE_ID" id="PROVINCE_ID" >
                     <option value="">Sélectionner</option>
                     <?php
                     foreach ($provinces as $value){
                       if ($value['PROVINCE_ID'] == $PROVINCE_ID){?>
                         <option value="<?=$value['PROVINCE_ID']?>" selected><?=$value['PROVINCE_NAME']?></option>
                       <?php } else{ ?>
                         <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                       <?php } } ?>
                     </select>
                   </div>
                 </div>
                   <div class="col-md-3 col-sm-2">
                     <div class="form-group">
                      <LABEL>Commune</LABEL>   
                      <select class="form-control"onchange="submit_com();get_rapport()" name="COMMUNE_ID" id="COMMUNE_ID">
                       <option value="">Sélectionner</option>
                       <?php
                       foreach ($communes as $value){
                        if ($value['COMMUNE_ID'] == $COMMUNE_ID){?>
                         <option value="<?=$value['COMMUNE_ID']?>" selected><?=$value['COMMUNE_NAME']?></option>
                       <?php } else{ ?>
                         <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
                       <?php } } ?>
                     </select>
                   </div>
                 </div>
                 <div class="col-md-3 col-sm-2">
                  <div class="form-group">
                   <LABEL>Zone</LABEL>  
                   <select class="form-control"onchange="submit_zon();get_rapport()" name="ZONE_ID" id="ZONE_ID">
                     <option value="">Sélectionner</option>
                     <?php
                     foreach ($zones as $value){
                      if ($value['ZONE_ID'] == $ZONE_ID){?>
                       <option value="<?=$value['ZONE_ID']?>" selected><?=$value['ZONE_NAME']?></option>
                     <?php } else{ ?>
                       <option value="<?=$value['ZONE_ID']?>"><?=$value['ZONE_NAME']?></option>
                     <?php } } ?>
                   </select>
                 </div>
               </div>
               <div class="col-md-3 col-sm-2">
                <div class="form-group">
                 <LABEL>Colline</LABEL> 
                 <select class="form-control"onchange="get_rapport()" name="COLLINE_ID" id="COLLINE_ID">
                  <option value="">Sélectionner</option>
                  <?php
                  foreach ($collines as $value){
                   if ($value['COLLINE_ID'] == $COLLINE_ID){?>
                    <option value="<?=$value['COLLINE_ID']?>" selected><?=$value['COLLINE_NAME']?></option>
                  <?php } else{ ?>
                    <option value="<?=$value['COLLINE_ID']?>"><?=$value['COLLINE_NAME']?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModalS" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreS"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableS' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModalQ" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreQ"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableQ' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>Localite</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModalDI" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreDI"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableDI' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>NOM</th><th>PRENOM</th><th>SEXE</th><th>ETAT&nbspCIVIL</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>PROVINCE</th> <th>COMMUNE</th><th>ZONNE</th><th>COLLINE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

      <div class="modal fade" id="myModalEC" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreEC"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableEC' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModalNIV" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreNIV"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableNIV' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

     <div class="modal fade" id="myModalHA" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreHA"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableHA' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>TYPE&nbspD'HANDICAP</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModalAGE" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titreAGE"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytableAGE' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="myModal1" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titre1"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytable1' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>BENEFICIAIRE</th><th>HANDICAP</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

      <div class="modal fade" id="myModalcoop" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titrecoop"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytablecoop' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                  <th>#</th><th>NOM&nbspDE&nbspLA&nbspCOOPERATIVE</th><th>NOMBRE&nbspD&nbsp'&nbspHOMMES</th><th>NOMBRE&nbspDE&nbspFEMMES</th><th>NIF</th><th>RC</th><th>DATE&nbspDE&nbspCREATION</th><th>DATE&nbspD&nbsp'&nbspINSERTION</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModalcoop1" role="dialog">
      <div class="modal-dialog modal-lg" style ="width:1000px">
        <div class="modal-content  modal-lg">
          <div class="modal-header">
            <h4 class="modal-title"><span id="titrecoop1"></span></h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table id='mytablecoop1' class='table table-bordered table-striped table-hover table-condensed' style="width:1200px">
                <thead>
                 
                  <th>#</th><th>BENEFICIAIRE</th><th>TELEPHONE</th><th>EMAIL</th><th>SEXE</th><th>TYPE</th><th>ETAT&nbspCIVIL</th><th>NIVEAU&nbspD&nbsp'&nbspINSTRUCTION</th><th>DIPLOME</th><th>DATE&nbspDE&nbspNAISSANCE</th><th>LOCALITE</th>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12" style="margin-bottom: 20px"></div>
      <div id="container"  class="col-md-6" ></div>
      <div id="container1"  class="col-md-6"></div>
      <div class="col-md-12" style="margin-bottom: 20px"></div>
      <div id="container3"  class="col-md-12"  ></div>
      <div class="col-md-12" style="margin-bottom: 20px"></div>
    </div>

  </main>


  <br>

 
  <div id="nouveau">
  </div>
  <div id="nouveau1">
  </div>

  <div id="nouveau2">
  </div>

  <div id="nouveau3">
  </div>
  
      </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
          get_rapport();
        });
      </script>
      <script>
       function get_rapport(){
         var PROVINCE_ID=$('#PROVINCE_ID').val();
         var COMMUNE_ID=$('#COMMUNE_ID').val();
         var ZONE_ID=$('#ZONE_ID').val();
         var COLLINE_ID=$('#COLLINE_ID').val();
         var STATUT=$('#STATUT').val();
         var FORMATION_ID=$('#FORMATION_ID').val();
         var DATE1=$('#DATE1').val();
        var DATE2=$('#DATE2').val();
         $.ajax({
           url : "<?=base_url()?>/dashboard/Dashboard_General_Citoyen/get_rapport",
           type : "POST",
           dataType: "JSON",
           cache:false,
           data:{
            PROVINCE_ID:PROVINCE_ID,
            COMMUNE_ID:COMMUNE_ID,
            ZONE_ID:ZONE_ID,
            COLLINE_ID:COLLINE_ID,
             },
          success:function(data){   
            $('#container').html("");             
            $('#nouveau').html(data.rapp);
            $('#container1').html("");             
            $('#nouveau1').html(data.rapp1);
            $('#container2').html("");             
            $('#nouveau2').html(data.rapp2);
            $('#container3').html("");             
            $('#nouveau3').html(data.rapp3);
            $('#COMMUNE_ID').html(data.comm);
            $('#ZONE_ID').html(data.zon); 
            $('#COLLINE_ID').html(data.col); 
          },            

        });  
       }
       function submit_prov() {
        $('#COMMUNE_ID').html('');
        $('#ZONE_ID').html('');
        $('#COLLINE_ID').html('');
      }
      function submit_com() {
        $('#ZONE_ID').html('');
        $('#COLLINE_ID').html('');

      }

      function submit_zon() {
        $('#COLLINE_ID').html('');
      }
    </script>
  </body>
  </html>

  