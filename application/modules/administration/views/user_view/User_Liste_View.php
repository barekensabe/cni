<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
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
              $new = '';
              $list = 'active';
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
                                   <h4 class=""><b>Liste des utilisateurs</b></h4>  
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                   <?php include 'includes/sous_menu_user.php' ?> 
                                </div>
                            </div>  
                        </div>


                        <?=$this->session->flashdata('message')?> 
                        

                            
                    <div class="col-md-12 jumbotron" style="padding: 5px">  
                       <div class="table-responsive">                                                   
                        <?php echo $this->table->generate($user_list); ?>
                        </div>                      
                    </div>
                      
                </div>
                </div>
                </div>
                </div>
                </div>


    </body>
    <script>
        $(document).ready(function () {
            $("#user_list").DataTable({
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
</html>
