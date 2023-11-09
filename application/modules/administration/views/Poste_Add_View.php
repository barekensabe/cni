<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH. 'includes/header.php' ?>
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
              $cge1 = 'active';
              $cge2 = '';
              $cge3 = '';
              $cge4 = '';
              $cge5 = '';
            ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" style=" margin-bottom: 5px">
                             <div class="row" style="" id="conta">
                                <?=$breadcrumb?> 
                             </div>
                            <div class="row" id="conta" style="margin-top: -10px">
                                 <div class="col-lg-4 col-md-4">                                  
                                   <h4 class=""><b>Enregistrement d'un poste</b></h4>  
                                </div>
                                <div class="col-lg-8 col-md-8" style="padding-bottom: 3px">
                                    <?php include 'includes/sous_menu_poste.php' ?>
                                </div>
                            </div>  
                        </div>
                 </div>


                            
    <div class="col-md-12 jumbotron" style="...">
        <form   name="myform" method="post" class="form-horizontal" action="<?= base_url('rh/Conge/enregistrer'); ?>"> 
            <div class="form-group">  
                <label class="col-md-4 col-sm-12 col-xs-12 control-label"> Service </label>
                    <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">  
                        <select required class="form-control" name="EMPLOYE_ID">
                               <option disabled selected value="">-Sélectionner-</option>
                      <?php foreach ($employes as $employ): ?>

                            <option value="<?=$employ['EMPLOYE_ID']?>"><?=$employ['EMPLOYE_NOM'].' '.$employ['EMPLOYE_PRENOM']?></option>

                            <?php endforeach?>
                        </select>
                    </div>
            </div>

           
                <div class="form-group">  
                    <label class="col-md-4 col-sm-12 col-xs-12 control-label"> Poste </label>
                    <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">  
                        <input type="text" name="POSTE" class="form-control">
                    </div>
            </div>
            <div class="form-group">  
                    <label class="col-md-4 col-sm-12 col-xs-12 control-label"> Niveau </label>
                    <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">  
                      <select class="form-control" name="NIVEAU">
                         <option disabled selected value="">-Sélectionner-</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                      </select>
                    </div>
            </div>

             
<div class="form-group">
                               <table class="table table-bordered">
                                   <thead>
                                       <th colspan="16" class="text-center"><h4>Droits d'accès</h4></th>
                                   </thead>
                                   <tbody>
                                       <tr>
                                           <td colspan="8" class="text-center"><label>Ressources Humaines</label></td>
                                           <td colspan="8" class="text-center"><label>Compte Rendu d'Activité</label></td>
                                       </tr>
                                       
                                       <tr>
                                           <td><input type="checkbox" name=""></td>
                                           <td>Services</td>
                                            <td><input type="checkbox" name=""></td>
                                           <td>Empoyés</td>
                                           <td><input type="checkbox" name=""></td>
                                           <td>Cotations</td>
                                            <td><input type="checkbox" name=""></td>
                                           <td>Congés</td>

                                           <td><input type="checkbox" name=""></td>
                                           <td>Projets</td>
                                            <td><input type="checkbox" name=""></td>
                                           <td>Tâches</td>
                                           <td><input type="checkbox" name=""></td>
                                           <td>Activités</td>
                                            <td><input type="checkbox" name=""></td>
                                           <td>Affectation</td>
                                            
                                            
                                       </tr>
                                   </tbody>
                               </table>
                            </div>
            

             <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label"></label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="submit" class="btn btn-primary btn-block" value="Enregistrer"/>
                                </div>
                            </div>
        </div>
        </div>


    </body>
    <script>
        $(document).ready(function () {
            $("#list_conge").DataTable({
                    language: {
                                "sProcessing":     "Traitement en cours...",
                                "sSearch":         "Rechercher&nbsp;:",
                                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                "sInfoPostFix":    "",
                                "sLoadingRecords": "Chargement en cours...",
                                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                                "oPaginate": {
                                    "sFirst":      "Premier",
                                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                                    "sNext":       "Suivant",
                                    "sLast":       "Dernier"
                                },
                                "oAria": {
                                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                                }
                        }
            });
            $(".dt-buttons").addClass("pull-left");
            $("#table_Cras_paginate").addClass("pull-right");
            $("#table_Cras_filter").addClass("pull-left");
        });

    </script>

    <script>

            $(function () {
                $("#dateDbuprobable").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd',
                    // startDate:'0',
                    // minDate: new Date(),
                    // todayHighlight: true,
                    autoclose: true
                });

                $("#dateFinprobable").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    format: 'yyyy-mm-dd',
                    // startDate:'0',
                    // minDate: new Date(),
                    // todayHighlight: true,
                    autoclose: true
                });
            });

        </script>

        <script language="javascript" type="text/javascript">
            function validerTousLesChamps() {
                
                var dateDbuprobable = document.getElementById('dateDbuprobable').value;
                var dateFinprobable = document.getElementById('dateFinprobable').value;
                var fin = new Date(dateFinprobable);
                var debut = new Date(dateDbuprobable);

                if (debut > fin)
                {
                    alert('La date début ne doit pas être postérieure à la date fin prévue');
                    //            document.getElementById('dateerror').innerHTML = '<font class=" alert-danger">La date debut ne doit pas etre postérieure à la date fin prévue</font>';
                    return false;
                }
                else
                {

                    return true;
                }

            }
        </script>
</html>
