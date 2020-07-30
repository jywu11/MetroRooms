
<?php
/**
 * @var \App\View\AppView $this
 * @var $properties
 */
?>

<!-- load DataTables formatting files -->
<?php
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Metrorooms Admin</title>
    <?php /*$this->assign("title","NAIM Admin | Home"); */?>
    <?php $uid = $this->getRequest()->getSession()->read('Auth.User.id'); ?>

</head>
<!-- end of header -->

<style>
    .my_hover{
        border: 2px solid #e7e7e7;
    }
    .my_hover:hover{
        background-color: #e7e7e7;
    }
</style>

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>

<!-- end of top nav bar -->

<!-- page content -->
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <h1>Dashboard</h1>
        </div>
        <div class="content">
            <div class="btn-controls">
                <div class="btn-box-row row-fluid">
                    <a href="admins/propertyManage" class="btn-box big span4 my_hover">
                        <?php
                        echo $this->Html->image('house.svg', [
                            'style' => 'max-width:30%;height:auto;',
                        ])
                        ?>
                        <!--<i class="icon-random"></i><b></b>-->
                        <p class="text-muted" style="font-size:95%">
                            Property Management</p>
                        <?php
                        $counter = 0;
                        foreach ($properties as $property){
                            $counter += 1;
                        }
                        ?>
                        <p class="text-muted" style="color:black;"><?php echo $counter; ?> Active Properties</p>

                    </a>

                    <!--<a href="#" class="btn-box big span4 my_hover"><i class="icon-user"></i><b></b>
                        <p class="text-muted">
                            Room Availability Management</p>
                    </a>-->

                    <a href="admins/applicationManage" class="btn-box big span4 my_hover">
                        <?php
                        echo $this->Html->image('application_2.svg', [
                            'style' => 'max-width:30%; height:auto;',
                        ])
                        ?>
                        <p class="text-muted" style="font-size:95%;">
                            Application Management</p>
                        <?php
                        $counter = 0;
                        foreach ($applications as $application){
                            $counter += 1;
                        }
                        ?>

                        <p class="text-muted" style="color:black;"><?php echo $counter; ?> Unprocessed Applications</p>
                    </a>

                    <a href="rentals/index" class="btn-box big span4 my_hover">
                        <?php
                        echo $this->Html->image('rent.svg', [
                            'style' => 'max-width:30%; height:auto;',
                        ])
                        ?>
                        <p class="text-muted" style="font-size:95%;">
                            Rental Management</p>
                        <?php
                        $counter = 0;
                        foreach ($rentals as $rental){
                            $counter += 1;
                        }
                        ?>
                        <p class="text-muted" style="color:black;"><?php echo $counter; ?> Active Rentals</p>
                        
                    </a>

                </div>
                <div class="btn-box-row row-fluid">
                    <a href="admins/feature_manage" class="btn-box big span4 my_hover">
                        <br>
                        <?php
                        echo $this->Html->image('feature.svg', [
                            'style' => 'max-width:25%; height:auto;',
                        ])
                        ?><br><br>
                        <p class="text-muted" style="font-size:95%; padding-bottom:10px;">
                            Feature/Item/Others Management</p>

                        <P></P>
                    </a>

                    <a href="frontcontents/index" class="btn-box big span4 my_hover">
                        <br>
                        <?php
                        echo $this->Html->image('front.svg', [
                            'style' => 'max-width:28%; height:auto;',
                        ])
                        ?>
                        <p class="text-muted" style="font-size:95%; padding-top:10px; padding-bottom:10px;">
                            Front-end Content Management</p>
                        <P></P>
                    </a>




                    <!--           <a href="users/" class="btn-box big span4 my_hover" style="">
                                         <?php
         /*                                                 echo $this->Html->image('user.svg', [
                                                                 'style' => 'max-width:28%; height:auto; padding-top:10px;',
                                                             ])
                                                             */?>
                                   <br>
                                         <p class="text-muted" style="font-size:95%; padding-bottom:10px;padding-top:20px;">
                                             User Account Management</p>
                                   <p></p>
                                     </a>-->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- end of page content -->

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->




