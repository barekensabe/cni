
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

	                <div id="page-wrapper">
				        <div class="col-md-12 jumbotron" style="padding: 5px">  
			               <?=$message?> <a href="<?=$retour?>" class="btn  btn-primary"><?=$invitation?> </a>
			            </div>
	                </div>
                </div>
            </div>
        </body>
  </html>
