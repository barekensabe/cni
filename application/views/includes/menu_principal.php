<?php
    //echo '1'.$this->session->userdata('LOGO');
 ?>
<style type="text/css">
    .jumbotron, #conta{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    background-color: white;
    }
  }
    #cont, #wrapper, #navp{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    }
     
    #cont:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    #wrapper:hover {
        box-shadow: 0 8px 16px 0 #063361;
    }
    #side-menu li a{
        color:white;
    }
    #side-menu li a:hover{
        color:#253E62;


    }
    
    #side-menu li a.active{
        color:#253E62;

        
    }
    #tete li a {
        color: black;
        font-weight: bold;
    }
    #tete li a:hover {
        color: #253E62;
    }
    #act{
        border:1px solid #253E62;
    }

    #men:focus{
        color: #253E62;
    }



    

    
</style>


            <div class="col-lg-3" style="margin-left: -14px">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="<?= base_url() ?>upload/banderole/logo.jpeg" style="width:250px;height: 67px "/>
                
                <!-- <img src="img/expertise.jpg" style="width: 100px;height: 70px"> -->
                
            </div>
            <!-- /.navbar-header -->
            <div class="col-lg-3"><h2 style="text-align: right">GESTION CNI</h2></div>
            <div class="col-lg-6">
                
                <ul class="nav navbar-top-links navbar-right" id="tete" style="padding:8px">    
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a  href="<?=$this->session->userdata('LOGIN')?>">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Reporting
                    </a>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                   <?= $this->session->userdata('LOGIN') ?><i class="fa fa-caret-down"></i> 
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?=base_url()?>Change_Pwd"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url()?>index.php/Login/do_logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                </ul>
            </div>

                <div class="navbar-default sidebar" id="cont" role="navigation" style="background-color: #253E62;margin-top: 72px">
                <div class="sidebar-nav navbar-collapse" id="side-menu">
                    <ul class="nav">

                      
                    <?php if($this->session->userdata('ADMINISTRATION')==1){?>

                                        <li>
                                            <a href="#" id="men"><i class="fa fa-group fa-fw"></i> Administration <span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                

                                                
                                                <li>
                                                    <a href="<?php echo base_url('index.php/administration/Users/liste') ?>" id="user">Utilisateurs </a>
                                                </li>

                                                 
                                                
                                                <li>
                                                    <a href="<?php echo base_url('index.php/administration/Profils/index') ?>" id="pro"> Profils et droits </a>
                                                </li>
                                                
                                            </ul>
                                            <!-- /.nav-second-level -->
                                        </li>
                                  <?php } if ($this->session->userdata('BI')==1) { ?>

                                        <li>
                                            <a href="#" id="men"><i class="fa fa-tasks fa-fw"></i>BI<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                
                                                 <li>
                                                    <a href="<?php echo base_url('index.php/dashboard/Dashboard_General_Citoyen') ?>" id="dash">Dashboard citoyen</a>
                                                </li>
    
                                                
                                            </ul>
                                            <!-- /.nav-second-level -->
                                        </li>

                                        <?php } if ($this->session->userdata('IHM')==1) {?>

                                        <li>
                                            <a href="#" id="men"><i class="fa fa-tasks fa-fw"></i>IHM<span class="fa arrow"></span></a>
                                            <ul class="nav nav-second-level">
                                                
                                                 <li>
                                                    <a href="#" id="act">Inscription </a>
                                                </li>
    
                                                
                                            </ul>
                                            <!-- /.nav-second-level -->
                                        </li>

                                        <?php } ?>

                
                                                 
                                                
                                                
                                            </ul>
                                            <!-- /.nav-second-level -->
                                        </li>




                              
                      
                                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>