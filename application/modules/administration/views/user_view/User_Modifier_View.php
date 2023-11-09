
<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
        <script>
            $(function () {
                $("#datedebut").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd',
                    startDate:'0',
                    minDate: new Date(),
                    todayHighlight: true,
                    autoclose: true
                });

                $("#datefin").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd',
                    startDate:'0',
                    minDate: new Date(),
                    todayHighlight: true,
                    autoclose: true
                });
            });


        </script>
        <script language="javascript" type="text/javascript">
            function validerTousLesChamps() {
                
                var datedebut = document.getElementById('datedebut').value;
                var datefin = document.getElementById('datefin').value;
                var fin = new Date(datefin);
                var debut = new Date(datedebut);

                if (debut > fin)
                {
                    alert('La date debut ne doit pas etre postérieure à la date fin prévue');
                    //            document.getElementById('dateerror').innerHTML = '<font class=" alert-danger">La date debut ne doit pas etre postérieure à la date fin prévue</font>';
                    return false;
                }
                else
                {

                    return true;
                }

            }
        </script>

    </head>
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
              $projet1 = '';
              $projet2 = 'active';
            ?>
            <div id="page-wrapper">
               <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-6 col-md-6">                                  
                                   <h4 class=""><b>Modification du Projet <?php echo $DESCR_PROJET ?></b></h4>
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'includes/sous_menu_projet.php' ?> 
                                </div>
                            </div>  
                        </div>
                    </div>

                            
                    <div class="row jumbotron" style="padding: 5px">  

                            <form   name="myform" method="post" class="form-horizontal" action="<?= base_url('cra/Projet/modifier_projet'); ?>">
                        
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Description</label>

                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                <input type="hidden" name="STATUT"  value="<?=$STATUT ?>"> 
                                    <input type="hidden" name="ID_PROJET"  value="<?=$ID_PROJET ?>">

                                    <input type="text" autofocus name="DESCR_PROJET"  value="<?php echo !empty($DESCR_PROJET) ? $DESCR_PROJET : ''; ?>" class="form-control">
                                    <span class="error"><?php echo form_error('DESCR_PROJET'); ?></span> 

                                    
                                </div>
                            </div>

                           
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Date début</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="text" id="datedebut"  name="DATE_DEBUT"  value="<?php echo!empty($DATE_DEBUT) ? $DATE_DEBUT : date('Y-m-d'); ?>" required="required" class="form-control"> 
                                     <span class="error"><?php echo form_error('DATE_DEBUT'); ?></span>   
                                </div>

                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Date fin prevue</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="text" id="datefin" name="DATE_FIN" value="<?php echo!empty($DATE_FIN) ? $DATE_FIN : date('Y-m-d'); ?>" required="required"  class="form-control">
                                      <span class="error" id="dateerror"><?php echo form_error('DATE_FIN'); ?></span>   
                                </div>

                            </div>
                            
                            <!-- <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Nb heures prévues</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                     <input type="number" min="1" step="0.01" name="NB_HEURES_PREVUES" value="<?php echo!empty($NB_HEURES_PREVUES) ? number_format($NB_HEURES_PREVUES, '1') : ''; ?>"  class="form-control">
                                            <span class="error"><?php echo form_error('NB_HEURES_PREVUES'); ?></span>  
                                </div>

                            </div> -->
                            
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Responsable</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                <select class="form-control" name="ID_COLLABO_RESPONSABLE">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                      foreach ($collabos as $collabo) {
                                     
                                        ?>
                                         <option value="<?=$collabo['EMPLOYE_ID']?>"><?=$collabo['EMPLOYE_PRENOM'].' '.$collabo['EMPLOYE_NOM']?></option>

                                        <?php
                                      }
                                        ?>
                                </select> 
                                 <span class="error" id="dateerror"><?php echo form_error('ID_COLLABO_RESPONSABLE'); ?></span>                             

                            </div>
                           
                           </div>    
                       
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label"></label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="submit" class="btn btn-primary btn-block" value="Modifier"/>
                                </div>
                            </div>
                       

                </form>
                           
           
                     
            </div>         
        </div>
    </body>
</HTML>
