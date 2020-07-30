<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Property $property
 */
?>


<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Property | Admin</title>
    <?php $this->assign("title","View Property | NAIM Admin"); ?>
</head>
<!-- end of head -->


<style>

    #action{
        margin-bottom: 0;
    }

    .inline_field{
        display: inline-block;
    }

    #officeuse{
        background-color: rgba(240, 176, 117, 0.2);
        border-radius: 10px;
    }

    #actiongroup{
        background-color: rgba(240, 176, 117, 0.2);
        border-radius: 10px;
    }

    #mybutton{
        margin-left: 3px;
    }

    #interviewButton{
        color: white;
        background-color: #ed969e;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, lightpink, #ed969e);
        background: -moz-linear-gradient(top, lightpink, #ed969e);
        background: -ms-linear-gradient(top, lightpink, #ed969e);
        margin-left: 3px;
    }

    #restoreButton{
        color: white;
        background-color: deepskyblue;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, deepskyblue,dodgerblue);
        background: -moz-linear-gradient(top, deepskyblue,dodgerblue);
        background: -ms-linear-gradient(top, deepskyblue, dodgerblue);
        margin-left: 3px;
    }

    #archiveButton{
        color: white;
        background-color: dimgrey;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, darkgrey,dimgrey);
        background: -moz-linear-gradient(top, darkgrey,dimgrey);
        background: -ms-linear-gradient(top,darkgrey, dimgrey);
        margin-left: 3px;
    }

    .button:hover{
        text-decoration: underline;
    }
    .button{

    }

    ul.breadcrumb {
        padding: 10px;
        list-style: none;
        background-color: white;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 0;
        color: black;
        content: "/\00a0";
    }
    ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }


     .google-maps {
         position: relative;
         padding-bottom: 30%;
         height: 0;
         overflow: hidden;
     }

    .google-maps iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }


</style>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>


<!-- retrieved displayed data -->
<?php
    $id = $property->id;
    $country = $property->country;
    $state = $property->state;
    $suburb = $property->suburb;
    $street = $property->street;
    $postcode = $property->postcode;
    $unit_num = $property->house_number;
    $br_num = $property->number_of_bedroom;
    $ba_num = $property->number_of_bathroom;
    $t_num = $property->number_of_toilet;
    $info = $property->general_information;
    $st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
    $location = $st_location.", ".$country;

?>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->



<!-- page content -->
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <ul class="pull-left" style="padding-right:10px;">
                <?php
                echo $this->Html->link(
                    'Back',
                    $this->request->referer(),
                    ['class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
            <ul class="breadcrumb inline_field">
                <li>
                    <?php
                    echo $this->Html->link(
                        'Dashboard',
                        ['controller' => 'Admins', 'action' => 'cpanel'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Properties',
                        ['controller' => 'Admins', 'action' => 'property_manage'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>View</li>
            </ul>
        </div>

        <br>
        <div>
            <h1>Property Details</h1>
        </div>

        <!-- action groups -->
        <div class="inline_field">
            <?php
            echo $this->Html->link(
                ' Edit',
                ['controller' => 'Properties', 'action' => 'admin_edit', $property->id],
                ['id' => 'mybutton', 'class' => 'button btn-large span4  btn-warning fas fa-edit', 'style' => 'width:100px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
            );
            ?>
        </div>
        <?php
        if ($property->property_status != 1){
            ?>
            <div class="inline_field">

                <?php

                echo $this->Form->postButton(
                    ' Archive',
                    ['controller' => 'Properties', 'action' => 'archive', $property->id],
                    ['confirm' => 'Are you sure to archive this Property?',
                        'class' => 'button btn-large span3 fas fa-folder',
                        'id' => 'archiveButton',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                );
                ?>
            </div>
            <?php
        }else{
            ?>
            <div class="inline_field">
                <?php
                echo $this->Html->link(
                    ' Restore',
                    ['controller' => 'Properties', 'action' => 'restore', $property->id],
                    ['class' => 'button btn-large span4 fas fa-folder-open',
                        'confirm' => 'Are you sure to restore this Property?',
                        'id' => 'restoreButton',
                        'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                );
                ?>
            </div>

            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Properties', 'action' => 'adminDelete', $property->id],
                    ['confirm' => 'All non-active rentals and application placed on this property will ALSO be deleted.\nThis property will be deleted forever and you CANNOT undo the action.\nAre you sure to delete this Property?',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        <?php
        }
        ?>

        <!-- action groups -->

        <br>

        <!-- Address View -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <?php echo "<h1>".$location."</h1>"; ?>
                    </div>


                    <!-- Office Use -->
                    <!-- Could add: #people currently statying/total_capacity, #application on this property -->
                    <div class="control-group" id="officeuse">
                        <div class="control-group" style="padding-left:5px;">
                            <h3>Office Use</h3>
                            <?php
                            if ($property->property_status == 0){
                                $status = "<h4 class='inline_field'><u>Active</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            } else{
                                $status = "<h4 class='inline_field' style='color:red;'><u>Archived</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            echo "<h5 class='inline_field'>Property Status: &nbsp;&nbsp;</h5>".$status."";
                            $cd = $property->create_date;
                            $enquiry_date =  'on '.$this->Time->format(
                                    $cd, #Your datetime variable
                                    'dd/MM/Y HH:mm'            #Your custom datetime format
                                );
                            echo "<h5 class='inline_field'>Created Date: &nbsp;&nbsp;</h5><h4 class='inline_field'><u>".$enquiry_date."</u></h4>";
                            ?>
                        <br><br>
                            <h4>Room and Photo Management on this Property</h4>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->postButton(
                                    'Manage Rooms',
                                    ['controller' => 'Rooms', 'action' => 'index', $id],
                                    ['class' => 'button btn-large btn-info']
                                );
                                ?>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->postButton(
                                    'Manage Photos',
                                    ['controller' => 'PropertiesImages', 'action' => 'adminEdit', $id],
                                    ['class' => 'button btn-large btn-info']
                                );
                                ?>
                            </div>
                        </div>

                    </div>
                    <!-- End Office use -->

                    <div class="control-group">
                        <div>
                            <h3 class="inline_field">House Details</h3>
                        </div>
                            <?php
                            if ($property->type == null){
                                echo "<h5 class='inline_field'>House Type: &nbsp;&nbsp;</h5><h4 class='inline_field'>No Type</h4>";
                            }else{
                                echo "<h5 class='inline_field'>House Type: &nbsp;&nbsp;</h5><h4 class='inline_field'>".$property->type->name."</h4>";
                            }
                            echo "<br><h5 class='inline_field'>Number Of Bedroom: &nbsp;&nbsp;</h5><h4 class='inline_field'>".$br_num."</h4>";
                            echo "<br><h5 class='inline_field'>Number Of Bathroom: &nbsp;&nbsp;</h5><h4 class='inline_field'>".$ba_num."</h4>";
                            echo "<br><h5 class='inline_field'>Number Of Toilet: &nbsp;&nbsp;</h5><h4 class='inline_field'>".$t_num."</h4>";
                            ?>
                    </div>
                    <div class="control-group">
                        <h3>House Public Transport and Surroundings</h3>
                        <div style="padding-left:20px;">
                            <p class="fas fa-car inline_field" ></p><h4 class="inline_field"><b>&nbsp;Parking and Taxis</b></h4>
                            <?php
                            if (strlen($property->parking_taxi)==0){
                                echo "<p>This property doesn't have any Parking and Taxis information recorded.</p>";
                            }
                            echo "".$property->parking_taxi."";  ?>
                            <br>
                            <p class="fas fa-bus inline_field"></p><h4 class="inline_field"><b>&nbsp;Bus Routes and Tram Stops</b></h4>
                            <?php
                            if (strlen($property->bus_tram)==0){
                                echo "</p>This property doesn't have any Bus Routes or Tram Stops information recorded.</p>";
                            }
                            echo "".$property->bus_tram."";  ?>
                            <br>
                            <p class="fas fa-subway inline_field"></p><h4 class="inline_field"><b>&nbsp;Train Stations</b></h4>
                            <?php
                            if (strlen($property->train)==0){
                                echo "<p>This property doesn't have any Train Station information recorded.</p>";
                            }
                            echo "".$property->train."";  ?>
                            <br>
                            <p class="	fas fa-cocktail inline_field"></p><h4 class="inline_field"><b>&nbsp;House Surroundings</b></h4>
                            <?php
                            if (strlen($property->surrounding)==0){
                                echo "<p>This property doesn't have any House Surrounding information recorded.</p>";
                            }
                            echo "".$property->surrounding."";  ?>
                            <br>
                        </div>
                    </div>
                    <div class="control-group">
                        <h3>House Description</h3>
                        <div style="padding-left: 20px;">
                            <h4><b>House Rules</b></h4>
                            <?php
                            if (strlen($property->houserule)==0){
                                echo "<p>This property doesn't have any House Rule.</p>";
                            }
                            echo "".$property->houserule."";  ?>
                            <br>
                            <h4><b>Additional Description</b></h4>
                            <?php
                            if (strlen($info)==0){
                                echo "<p>This property doesn't have an Additional Description.</p>";
                            }
                            echo "".$info."";  ?>
                        </div>

                    </div>
                    <div class="control-group">
                        <h3>Map</h3>
                       <!-- <div style="background-color: lightgrey; border-radius: 10px;">  style="padding:10px;"-->

                                <?php
                                if (strlen($property->map)==0){
                                    echo "<p>This property doesn't have a map provided.</p>";
                                }else{
                                    echo " <div class=\"google-maps\">".$property->map."</div>";
                                }


                                ?>

                        <!--</div>-->
                    </div>

                    <div class="control-group">
                        <h3>Features</h3>
                        <?php
                        if (count($property->features)==0){
                            echo "<p>This property doesn't have any features.</p>";
                        }
                        foreach ($property->features as $feature){
                            echo "<p>".$feature->name."\n</p>";
                        }
                        ?>
                    </div>
                    <div class="control-group">

                        <h3>House Public Inventory</h3>
                        <?php
                        if (count($property->items)==0){
                            echo "<p>This property has no record of its public inventory.</p>";
                        }else{
                            $counter = 0;
                            foreach ($property->items as $item){
                                // echo "<p>".$property->items[0];
                                echo "<p>".$property->items[$counter]->_joinData->quantity." ".$property->items[$counter]->name."\n</p>";
                                $counter += 1;
                            }
                        }

                        ?>
                        <!--<h3>Under Development:: House Public Inventory</h3>
                        --><?php
/*                        //if (count($property->features)==0){
                        //    echo "<p>This property has no record of its public inventory.</p>";
                       // }
                        //foreach ($property->features as $feature){
                        //    echo "<p>".$property->items->quantity." ".$property->items->name.":\n</p>";
                       // }
                        */?>

                    </div>



                </div>
            </div>
        </div>
<ul class="pull-right">
    <?php
/*    echo $this->Form->postButton(
        'Delete',
        ['controller' => 'Properties', 'action' => 'adminDelete', $id],
        ['confirm' => 'Are you sure to delete this Property?\nIt will be delete permanently',
            'class' => 'button btn-large btn-danger']
    );
    */?>
</ul>
    </div>
</div>





<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
