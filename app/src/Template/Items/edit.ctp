<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item | Admin</title>
    <?php $this->assign("title","Edit Feature | NAIM Admin"); ?>
</head>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>

    .inline_field{
        display: inline-block;
    }

    .checkbox{
        padding-right: 30px;
        display:inline-block;
    }

    label.feature {
        /*border:1px solid #ccc;*/

        display:inline-block;
    }

    label.feature:hover {
        background:#eee;
        cursor:pointer;
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
</style>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<body>
<div class="wrapper">
    <div class="container">
        <!-- back button -->
        <ul class="pull-left inline_field" style="padding-right:10px;">
            <?php
            echo $this->Html->link(
                'Back',
                ['controller' => 'Items', 'action' => 'index'],
                ['confirm' => 'Are you sure to go back?\nThe changes you made will not be saved',
                    'class' => 'button btn-large btn-inverse']
            );
            // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
            ?>
        </ul>
        <!--  bread nav -->
        <ul class="breadcrumb inline_field">
            <li>
                <?php
                echo $this->Html->link(
                    'Dashboard',
                    ['controller' => 'Admins', 'action' => 'cpanel'],
                    ['class' => '', 'confirm' => 'Are you sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>
                <?php
                echo $this->Html->link(
                    'Item List',
                    ['controller' => 'Items', 'action' => 'index'],
                    ['class' => '', 'confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>Edit Feature</li>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
        <div>
            <h1>Edit Inventory Item</h1>
            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Items', 'action' => 'delete', $item->id],
                    ['confirm' => 'Are you sure to delete this Item?\nIt will be deleted forever from all the properties and rooms that are recording it.\nYou CANNOT undo the action',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        </div>

        <input value="<?php echo $item->location; ?>"  type="hidden"  id="loc">
        <?= $this->Form->create($item, ['id' => 'myform']) ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <fieldset>
                            <div>
                                <!-- location -->
                                <?php
                                // prepare location list
                                $lo_list = array();
                                $lo_list[0] = "Bedroom ONLY";
                                $lo_list[1] = "Public ONLY";
                                $lo_list[2] = "Bedroom and Public";

                                ?>
                                <?php
                                if ($item->location == 'p'){
                                    echo "<span style='color:red;'>**This item now is <b style='color:red'>Public only</b>, if you change its location to Bedroom ONLY, all its existing recorded in properties public area will be deleted.</span>";
                                }else if($item->location == 'b'){
                                    echo "<span style='color:red;'>**This item now is <b style='color:red'>Bedroom only</b>, if you change its location to Public ONLY, all its existing recorded in the bedroom areas will be deleted.</span>";
                                }else{
                                    echo "<span style='color:red;'>
**This item now is available in <b style='color:red'>Both Public areas and Bedrooms</b>, if you change its location to Bedroom ONLY or Public ONLY, all its existing recorded in the other areas will be deleted.</span>";
                                }
                                ?>
                                <?php
                                if ($item->location == 'p'){
                                    $loc = "Public ONLY";
                                }else if ($item->location == 'b'){
                                    $loc = "Bedroom ONLY";
                                }else{
                                    $loc = "Bedroom and Public";
                                }
                                echo $this->Form->control('location',
                                    ['label'=>'Change Item Location',
                                        'type' => 'select',
                                        'options' => $lo_list,
                                        'required' => 'required',
                                        'class' => 'span3',
                                        'id' => 'loc_select',
                                        'style'=>'height:40px;']);
                                ?><br>
                                <!-- name -->
                                <?php
                                echo $this->Form->control('name', ['label' =>'Change Item Name', 'type' => 'text',
                                    'class' => 'span4', 'style'=> 'height:40px;', 'data-validation'=>'custom',
                                    'data-validation-regexp' => "^([A-Za-z ()-_&*+=><!]+)$",
                                    'data-validation-error-msg'=> "Please enter a valid name"
                                ]);
                                ?>


                            </div>
                        </fieldset>
                    </div>
                    <div class="control-group">
                        <?php
                        if ($item->location == 'a'){
                            echo "<h4>This Item is included by the below Properties and Rooms</h4>";
                        }else if ($item->location == 'b' ){
                            echo "<h4>This Item is included by the below Rooms</h4>";
                        }else{
                            echo "<h4>This Item is included by the below Properties</h4>";
                        } ?>

                        <div style="padding-left:15px;">
                            <?php
                            $p_list = array();
                            $count = 0;
                            foreach ($item->properties as $p){
                                // for each property, display property first
                                $p_list[$count] = $p->id;
                                $count += 1;
                                $unit = $p->house_number;
                                $country = $p->country;
                                $state = $p->state;
                                $suburb = $p->suburb;
                                $st = $p->street;
                                $postcode = $p->postcode;

                                $addr = $unit." ".$st.", ".$suburb.", ".$state." ".$postcode.", ".$country;
                                echo "<p class='fas fa-home inline_field'></p><p class='inline_field'>&nbsp;".$addr."</p>";
                                ?>
                            <!-- If it's also store in a room belongs to the property-->
                                <?php
                                $counter = 0;
                                echo "<div style=\"padding-left:15px;\">";
                                foreach ($item->rooms as $r){
                                    if ($r->property_id == $p->id){
                                // if in a room is recording this item in this property as well, display room inside property
                                        if ($counter == 0){
                                            echo "<span class='inline_field'>The item is also included in these rooms of this property:</span>";
                                        }
                                        if ($counter == 0){?>
                                                        <span class="inline_field" style="padding-bottom:15px;"><?php echo "".$r->room_name;?></span>
                                        <?php }else{ ?>
                                                        <span class="inline_field"><?php echo ", ".$r->room_name;?></span>
                                        <?php }
                                        $counter += 1;
                                    }
                                }
                                echo "</div>";
                                if ($counter == 0){
                                    echo "<br>";
                                }
                            }
                            // if it stores in a room that is not belong to any properties listed above
                            foreach ($item->rooms as $r){
                                $flag = 0;
                                foreach ($properties_all as $p){
                                    // if this room belong to that property
                                    if ($r->property_id == $p->id){
                                        // check if this property is already displayed
                                        $flag = 0;
                                        foreach ($p_list as $pid){
                                            if ($pid == $r->property_id){
                                                // has been displayed
                                                $flag = 1;
                                                break;

                                            }
                                        }
                                        if ($flag == 0){
                                            // not displayed before, display
                                            $unit = $p->house_number;
                                            $country = $p->country;
                                            $state = $p->state;
                                            $suburb = $p->suburb;
                                            $st = $p->street;
                                            $postcode = $p->postcode;
                                            $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                                            $r_name = $r->room_name;
                                            echo "<p class='fas fa-bed inline_field'></p>&nbsp;<p class='inline_field'>".$r_name." "."</p><span class='inline_field'>&nbsp;in&nbsp;".$addr."</span><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save Item',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes on this Item for all the properties adn rooms?',
            ]); ?>
        <?= $this->Form->end() ?>

    </div>

</div>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->

</body>

<!-- set selected value -->
<script>
    $(document).ready(function(){
        var loc = document.getElementById("loc").value;
        //alert(loc);
        if (loc == 'b'){
            //  alert("bed");
            $('#loc_select option:eq(0)').prop('selected', true);  // To select via value
        }
        if (loc == "p"){
            // alert("public");
            $('#loc_select option:eq(1)').prop('selected', true);  // To select via value
        }
        if (loc == 'a'){
            $('#loc_select option:eq(2)').prop('selected', true);  // To select via value
            //    alert("all");
        }

    });
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

<script>
    $.validate({});
    $.validate({
        modules : 'toggleDisabled',
        disabledFormFilter : 'myform.toggle-disabled',
        showErrorDialogs : false
    });
</script>







