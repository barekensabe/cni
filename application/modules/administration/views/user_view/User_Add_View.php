
<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>


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
              $new = 'active';
              $list = '';
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
                                   <h4 class=""><b>Enregistrement d'un nouvel utilisateur</b></h4>
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'includes/sous_menu_user.php' ?> 
                                </div>
                            </div>  
                        </div>
                    </div>

                            
                    <div class="row jumbotron" style="padding: 5px">  

                            <form   name="myform" method="post" class="form-horizontal" action="<?= base_url('index.php/administration/Users/add'); ?>">
                        
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Nom</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="text" autofocus name="NOM"  value="<?php echo !empty($NOM) ? $NOM : ''; ?>" class="form-control"> 
                                        <span class="error"><?php echo form_error('NOM'); ?></span> 
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Prenom</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="text" autofocus name="PRENOM"  value="<?php echo !empty($PRENOM) ? $PRENOM : ''; ?>" class="form-control"> 
                                        <span class="error"><?php echo form_error('PRENOM'); ?></span> 
                                </div>
                            </div>



                        
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">E-mail</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="email" autofocus name="EMAIL"  value="<?php echo !empty($EMAIL) ? $EMAIL : ''; ?>" class="form-control"> 
                                        <span class="error"><?php echo form_error('EMAIL'); ?></span> 
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Téléphone</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="number" autofocus name="TEL"  value="<?php echo !empty($TEL) ? $TEL : ''; ?>" class="form-control"> 
                                        <span class="error"><?php echo form_error('TEL'); ?></span> 
                                </div>
                            </div>

           
                            
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Profil</label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                <select class="form-control" name="PROFIL_ID">
                                    <option value=""> - Sélectionner - </option>
                                    <?php
                                      foreach ($profiles as $profile) {
                                     
                                        ?>
                                         <option value="<?=$profile['PROFIL_ID']?>"><?=$profile['DESC_PROFIL']?></option>

                                        <?php
                                      }
                                        ?>
                                </select> 
                                 <span class="error" id="dateerror"><?php echo form_error('PROFIL_ID'); ?></span>                             

                            </div>
                           
                           </div>    
                       
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label"></label>
                                <div class="col-md-5 col-sm-12 col-xs-12 col-md-push-1">
                                    <input type="submit" class="btn btn-primary btn-block" value="Enregistrer"/>
                                </div>
                            </div>
                       

                </form>
                           
           
                     
            </div>         
        </div>
    </body>
</HTML>
