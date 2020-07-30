<!DOCTYPE html>
<html lang="en">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="metropolitan" content="metrorooms.com.au">


<?php
echo $this->Html->css([
    'admin_tem/bootstrap/bootstrap.min',
    'admin_tem/bootstrap/bootstrap-responsive.min.css',
    'admin_tem/theme.css',
    'admin_tem/font-awesome.css']);
echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600');
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
?>




<!-- topbar start -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <div style="display:inline;">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <?php echo $this->Html->image('admin_tem/picker.png')?>
                </a>

                <?php
                echo $this->Html->link(
                    'Metrorooms Administrator',
                    ['controller' => 'Admins', 'action' => 'index'],
                    ['class' => 'brand', 'style' => 'padding-top:30px;']
                );
                ?>

                <div class="nav-collapse collapse navbar-inverse-collapse">

                    <ul class="nav pull-right" style="padding-top:15px; padding-right: 50px;">
                        <!-- dashboard button -->
                        <?php
                        echo $this->Html->link(
                                'Dashboard',
                              ['controller' => 'Admins', 'action' => 'index'],
                             ['class' => '', 'style' => 'padding-right:10px;']
                          );
                        //button btn-lg btn-inverse border-radius: 8px
                        ?>
                        <!-- link to account page -->
                        <?php
                       $uid = $this->Session->read('Auth.User.id');
                        $myAccountPath ="edit/".$uid;
                        echo
                       $this->Html->link(
                         'My account',
                            ['controller' => 'Users', 'action' => $myAccountPath],
                            ['class' => 'button btn-lg btn-primary', 'style' => 'border-radius: 8px']
                        );
                       ?>
                        <!-- logout -->
                        <?php
                       echo $this->Html->link(
                           'Logout',
                            ['controller' => 'Users', 'action' => 'logout'],
                            ['class' => 'button btn-lg btn-inverse', 'style' => 'border-radius: 8px;']
                        );
                        ?>
                        </ul>



                        <!-- if can't resolve hidden dropdown list this has to go -->
                              <!--  <ul class="nav pull-right" style="top:10px">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Go to
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Item No. 1</a></li>
                                <li><a href="#">Don't Click</a></li>
                                <li class="divider"></li>
                                <li class="nav-header">Example Header</li>
                                <li><a href="#">A Separated link</a></li>
                            </ul>
                        </li>
                                </ul>-->



                </div>
                <!-- end of inline display -->
            </div>
            <!-- /.nav-collapse -->
        </div>
    </div>
    <!-- /navbar-inner -->
</div>
<!-- topbar ends -->


