
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
                                   <h4 class=""><b>Modification d'un nouvel profil</b></h4>
                                </div>
                                <div class="col-lg-6 col-md-6" style="padding-bottom: 3px">
                                    <?php include 'includes/sous_menu_profil.php' ?> 
                                </div>
                            </div>  
                        </div>
                    </div>

                            
    <div class="row jumbotron" style="padding: 5px">  

        <form id="myforms" action="<?php echo base_url('index.php/administration/Profils/update')?>" method="post" >
                <div class="form-group">
                  <label>Profil</label>

                  <input type="hidden" value="<?=$datas['PROFIL_ID']?>" name="PROFIL_ID">
                  <input type="text" class="form-control" id="DESC_PROFIL" name="DESC_PROFIL" value="<?=$datas['DESC_PROFIL']?>" autofocus required="required">
                  <div style="color: red"><?=form_error('DESC_PROFIL')?></div>
                </div>
                <div class="form-group">
                  <label>Droits</label><br>
                  
                  <input type="checkbox"  name="ADMINISTRATION" value="1" <?php echo ($datas['ADMINISTRATION']==1)? 'checked':'' ?>> ADMINISTRATION<br>
                  <input type="checkbox" value="1" name="IHM" <?php echo ($datas['IHM']==1)? 'checked':'' ?>>  IHM <br>
                  <input type="checkbox" value="1" name="BI" <?php echo ($datas['BI']==1)? 'checked':'' ?>> BI<br>


                </div>
                  <input type="submit" id="myforms" class="btn btn-primary btn-block" value="Enregistrer">
           </form>
                           
                    
            </div>         
        </div>
    </body>
</HTML>
