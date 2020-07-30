<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room | Admin</title>
    <?php $this->assign("title","Edit Room | NAIM Admin"); ?>
</head>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<!-- end of header -->
<script src="https://cdn.tiny.cloud/1/1zi0mrpc0n8ej1y390e310ybmi4bfvu7ukbwgst0rk1x6pre/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({selector:'#room-general-information'});
</script>

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

<!-- page content -->
<div class="wrapper">
    <div class="container">
        <!-- back button -->
        <div class="inline_field">
            <ul class="pull-left" style="padding-right:10px;">
                <?php
                echo $this->Html->link(
                    'Back',
                    ['controller' => 'Rooms', 'action' => 'index', $pid],
                    ['confirm' => 'Are you sure to go back?\nThe changes you made will not be saved',
                            'class' => 'button btn-large btn-inverse']
                );
                // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
                ?>
            </ul>
            <ul class="breadcrumb inline_field">
                <li>
                    <?php
                    echo $this->Html->link(
                        'Dashboard',
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                                'controller' => 'Admins', 'action' => 'cpanel'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Properties List',
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                                'controller' => 'Admins', 'action' => 'property_manage'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Property',
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                            'controller' => 'Properties', 'action' => 'admin_view', $pid],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Rooms',
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                                'controller' => 'Rooms', 'action' => 'index', $pid],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>Edit Room</li>
            </ul>
        </div>
        <br>
        <!-- header and back button -->
        <div class="inline_field">
            <h1>Edit Bedroom</h1>
            <div class="inline_field">
                <small>On property: </small>
            </div>
            <div class="inline_field">
                <?php // debug($property);?>
                <?php
                foreach ($property as $p){
                    $id = $p->id;
                    $country = $p->country;
                    $state = $p->state;
                    $suburb = $p->suburb;
                    $street = $p->street;
                    $postcode = $p->postcode;
                    $unit_num = $p->house_number;
                    $st_location = $unit_num." ".$street.", ".$suburb.", ".$state.$postcode;
                    $location = $st_location.", ".$country;
                } ?>
                <?php echo "<p>".$location."</p>";?>
            </div>
        </div>
        <input type="hidden" id="change_flag" value=0>

        <!-- Form created here -->
        <?= $this->Form->create($room, ['onsubmit' => 'return validateMyForm();',]) ?>
        <?php
        // 'beds_old_0_1'
        // 'beds_old_1_1'
        //  'beds_old_2_1'
        //  'beds_old_3_1'
        $this->Form->unlockField('beds');
        for ($i=0; $i<99; $i++){

            $this->Form->unlockField('beds.old.'.$i.'.0');
            $this->Form->unlockField('beds.old.'.$i.'.1');
            $this->Form->unlockField('beds.add.'.$i);
        }
        ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <fieldset>
                        <div class="control-group">
                            <div>
                                <?php
                                echo $this->Form->control('room_name', ['label' =>'Room Name', 'type' => 'text',
                                    'class' => 'span2'
                                ]);
                                ?>
                            </div>
                            <br>
                            <div class="inline_field" style="padding-right:5px;">
                                <?php
                                $type_list = array();
                                $type_list[0] = 'Private';
                                $type_list[1] = "Sharing";

                                echo $this->Form->control('room_type',
                                    ['label' => 'Room Type',
                                        'type' => 'select',
                                        'options'=>$type_list,
                                        'style'=>"padding-top:0;"
                                    ]); ?>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('room_type_desc', [
                                    'label' => 'Room Type Additional Description', 'type' => 'text', 'style' => 'height: 30px;'
                                ]);
                                ?>
                            </div>

                            <div id="type_desc_show" style="" onclick="hide_logo_info();">
                                <div style="margin-top:5px; padding-top: 5px; background-color: #fff9e1; border-radius: 5px;">
                                    <div style="padding-left:10px;">
                                        <p class="fas fa-info-circle"></p>&nbsp;<span>Click me to see what is 'Room Type Additional Description'</span>
                                    </div>
                                </div>
                            </div>
                            <div id="type_desc_hide" style="display:none;" onclick="show_logo_info();">
                                <div style="margin-top:5px; padding-top: 5px; background-color: #fff9e1; border-radius: 5px;">
                                    <div style="padding-left:10px; padding-bottom:5px;">
                                        <p class="fas fa-info-circle" style="color:black;"></p>&nbsp;
                                        <span style="">Click within the yellow box to close me</span><br>
                                        <span style="padding-left:20px; color:black;">'Room Type Additional Description' is for you to add in additional constraints on the room type.</span><br>
                                        <span style="padding-left:20px; color:black; padding-bottom:5px;">You can put in, for example: "Female Only Room"</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <br>


                    <h4>Beds Information</h4>
                    <?php
                    // Format bed selection array
                    $b_array = array();
                    $counter = 0;
                    foreach($beds as $bed){
                        $b_array[$counter][0] = $bed->id;
                        $b_array[$counter][1] = $bed->bed_name;
                        $counter += 1;
                    }
                    ?>
                    <!-- Beds Management -->
                    <div>
                        <a id="add_bed" class="btn btn-large btn-success" style="padding:5px;">
                            <p class="fas fa-plus inline_field" style="margin-bottom:0;"></p>&nbsp;&nbsp;<p class="inline_field" style="margin-bottom:0;">Add a Bed</p>
                        </a>

                        <div id="beds" style="margin-top:5px; padding-top: 0; background-color: #EAFAF1; border-radius: 5px;">
                            <br>
                            <!-- format id array -->
                            <?php
                            // CONSTRUCT BED ARRAY
                            $id_array = array();
                            $counter = 0;
                            foreach($room_beds as $bed){
                                // debug($bed);
                                //debug($beds);
                                foreach ($beds as $b){
                                    if ($b->id == $bed->bed_id){
                                        $id_array[$counter] = $b->id;
                                    }
                                }
                                $counter += 1;
                            }

                            $counter = 0;
                           // CONSTRUCT NAME ARRAY
                            $name_array = array();
                            foreach ($beds as $b) {
                                $name_array[$b->id] = $b->bed_name;
                                $counter += 1;
                            }
                            $counter = 0;
                            foreach($room_beds as $bed){
                               // debug($bed);
                                //debug($beds);
                                foreach ($beds as $b){
                                    if ($b->id == $bed->bed_id){
                                        $id_array[$counter] = $b->id;
                                    }
                                }
                                $counter += 1;
                            }
                            //debug($id_array);
                            ?>

                            <?php
                            $f = 0;
                            $counter = 0;
                            //debug($id_array);
                            //debug($name_array);
                            foreach ($room_beds as $rb){
                               // debug($rb);
                                //debug($counter);
                                //debug($id_array[$counter]);
                                //debug($room_beds);
                                $f = 1;
                                // display existing beds
                                ?>

                               <div class="my_bed old" style=padding-left:10px; id="entry<?php echo $counter; ?>">
                                    <a value="<?php echo $counter; // $id_array[$counter] ?>" class="btn btn-danger btn-small inline_field rm"
                                       style="padding:5px; margin-bottom: 3px; margin-right:3px;" id="<?php echo $counter; ?>">
                                        <p class="fas fa-minus inline_field" style="margin-bottom:0;"></p>
                                    </a>
                                   <div class="inline_field">
                                       <?php
                                       echo "<input type='hidden' class='oldID' id='oldID".$counter."' value='".$rb->id."'>";
                                       echo "<input type='hidden' id='deleteflag-".$counter."' value=".$rb->occupied.">"; // $id_array[$counter]
                                       echo $this->Form->control('beds.old.'.$counter.'.0',
                                           ['label' => '',
                                               'flag'=>$counter,
                                               'class' => 'inline_field old',
                                               'type' => 'select',
                                               'value' => $id_array[$counter],
                                               'options'=> $name_array,
                                               'style'=>"height:35px;"
                                           ]); // id_array[$counter];
                                       echo "<input type='hidden' name='beds[old][".$counter."][1]' id='beds[old][".$counter."][1]' value=".$rb->id.">";
                                      $counter += 1;
                                       ?>
                                   </div>
                                    <!--<select name="beds[_ids][id_counter]" class="inline_field" style="height:35px;">' +
                                        </select>-->
                                    <br><br></div>
                                <?php
                            }
                            ?>


                            <?php
                            if ($f == 0){
                                ?>
                                <div style="padding-left:10px;color:red;" id="ori">
                                    **<b style="color:red;">No Beds</b> Currently Being Recorded for this room.<br><br>
                                </div>
                            <?php
                            }
                            ?>
                        </div>


                        <?php
                        /*                                    echo $this->Form->control('room_capacity',
                                                                ['label' => 'Room Capacity', 'type' => 'number',
                                                                    'class' => 'span4'
                                                                ]);

                                                            */?>
                    </div>

                    <?php
                    echo "<input type=\"hidden\" value=".$counter." id=\"i\">"; // add counter
                    echo "<input type='hidden' value='0' id='j'>";   // delete counter

                    echo "<div id='deleted'></div>"

                    ?>
                    <!-- end bed Management -->

                    <hr>


                    <!-- room inventory -->
                    <div class="control-group">
                                    <h3>Room Inventory</h3>
                                    <div class="inline_field">

                                        <?= $this->Form->control('property_id', ['type'=>'hidden', 'default'=>$id]); ?>
                                        <label>Room Inventory:</label>
                                        <span style="color:red">*Note The <b style="color:red;">checkbox must be selected </b>to record its quantity.</span>
                                        <br>
                                        <?php
                                        $count = 0;
                                        foreach ($items as $it){
                                            $count += 1;
                                        };
                                        ?>
                                        <?php
                                        // debug($itemDetails);
                                        // prepare index array
                                        $id_array = array();
                                        $counter = 0;
                                        $name_array = array();
                                        // debug($itemDetails);
                                        foreach($itemDetails as $itemDetail){
                                            $id_array[$counter] = $itemDetail->id;
                                            $name_array[$counter] = $itemDetail->name;
                                            $counter += 1;
                                        }
                                        ?>


                                        <?php
                                        $counter = 0;
                                        foreach($itemDetails as $item){ ?>
                                            <?php
                                            $flag = 0;
                                            //debug($my_items);
                                            foreach ($my_items as $my_item){
                                                // debug($items);
                                                // debug($my_item);
                                                if ($item->id == $my_item->item_id){
                                                    echo "<div><div class=\"inline_field\">".$this->Form->control('items'.'._ids.' .$id_array[$counter],
                                                            ['class'=>'checkbox inventory my_checkbox','label'=> $name_array[$counter],'type'=>'checkbox', 'checked'=>true, 'value'=>$id_array[$counter]])."</div>";

                                                    echo "<div class=\"inline_field\">".$this->Form->control('items._joinData.'. $id_array[$counter].'.quantity',
                                                            ['class' => 'my_checkbox', 'label' => false, 'value' => $my_item->quantity,
                                                                'type'=>'number', 'style'=>'width:80%; height:25px;display:none;',
                                                                'placeholder'=>'Enter quantity',
                                                                'data-validation' => 'number',
                                                                "data-validation-error-msg" => "Please enter a valid quantity, range from 1 to 99.",
                                                                'data-validation-allowing'=>'range[1;99]']
                                                        )."</div></div>";
                                                    $flag = 1;
                                                }
                                            }
                                            if ($flag == 0){
                                                echo "<div><div class=\"inline_field\">".$this->Form->control('items'.'._ids.' .$id_array[$counter],
                                                        ['class'=>'checkbox inventory my_checkbox','label'=> $name_array[$counter],'type'=>'checkbox', 'value'=>$id_array[$counter]])."</div>";
                                                echo "<div class=\"inline_field\">".$this->Form->control('items._joinData.'. $id_array[$counter].'.quantity',
                                                        ['class' => 'my_checkbox', 'label' => false, 'type'=>'number', 'style'=>'width:80%; height:25px;display:none;',
                                                            'placeholder'=>'Enter quantity',
                                                            'data-validation' => 'number',
                                                            "data-validation-error-msg" => "Please enter a valid quantity, range from 1 to 99.",
                                                            'data-validation-allowing'=>'range[1;99]'
                                                            ]
                                                    )."</div></div>";
                                            }
                                            ?>

                                            <?php
                                            ?>
                                            <?php
                                            $counter += 1;
                                        }
                                        ?>


                                    </div>
                                    <br>
                                    <br>
                                </div>


                    <!-- room description -->
                    <div class="control-group">
                        <div class="inline_field">
                            <h3>Room Description</h3>
                            <?php
                            echo $this->Form->control('room_general_information',
                                ['label'=>'Room Description', 'type' => 'textarea',
                                    'class' => 'span12'
                                ]);
                            ?>
                            <span class="help-inline">
                In this section, please enter
                anything in addition of the information you have entered or selected so far
                (you will have a chance to upload image after you save this room)
            </span>
                        </div>
                    </div>


                   <!-- <hr>
                   <div class="control-group">
                        <div>
                            <h3>Room Availability</h3>

                            <?php
/*                            if ($room->rental_end_date==null){
                                echo "This room doesn't have a rental end date currently.";
                            }else{
                                echo "<span>Your current Rental End Date is: </span>".$room->last_rental_end_date->i18nFormat('dd-MM-yyyy');
                            }

                            */?>
                            <br><br>
                            <input type="checkbox" name="UPDATE_FLAG" value="UPDATE"><span style="color:red"> **Note <b style="color:red">ONLY when</b> this checkbox is selected, the Room Availability will be updated.</span><br><br>
                            <?php
/*
                            echo $this->Form->control('rental_end_date',
                                ['label'=>'Enter a New Rental End Date', 'type' => 'date',
                                    'class' => 'span12'
                                ]);
                            */?>
                            <div id="warning_div" style="display: none;">
                                <p id="warning" style="color:red; padding-left:5px;"></p>
                            </div>
                        </div>
                    </div>-->
                                <!-- Property information ends -->


                </div>
            </div>
        </div>
        <?php
        $this->Form->unlockField('UPDATE_FLAG');

        ?>
        <!-- end of header and head button -->
        <?php echo $this->Form->button('Save Room',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes?'

            ]); ?>
        <?= $this->Form->end() ?>

    </div>
</div>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->





<script>
    // logo help text
    function hide_logo_info() {
        var x = document.getElementById("type_desc_show");
        x.style.display = "none";
        var y = document.getElementById("type_desc_hide");
        y.setAttribute("style", "");
    }
    function show_logo_info(){
        var x = document.getElementById("type_desc_hide");
        x.style.display = "none";
        var y = document.getElementById("type_desc_show");
        y.setAttribute("style", "");
    }
</script>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

<!-- checkbox validation -->
<!-- end checkbox validation -->
<script>
    function validateMyForm(){
        let y = $('select[name="rental_end_date[year]"').children("option:selected").val();
        let m = $('select[name="rental_end_date[month]"').children("option:selected").val();
        let d = $('select[name="rental_end_date[day]"').children("option:selected").val();
        let givenDate = y +"-"+ m + "-"+ d;
        let currentDate = new Date();
        givenDate = new Date(givenDate);
        if (givenDate > currentDate){
            let my_check = $('input[name="UPDATE_FLAG"').is(":checked");
            let flag = document.getElementById("change_flag").value;
            if (my_check == false && flag == 10){
                let r = confirm("You haven't select the checkbox for saving the new date, are you sure to save and leave?\nYour newly entered Date will NOT be saved.");
                if (r == true){
                    return true;
                }else{

                    return false;
                }
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
</script>


<!-- check date -->
<script>

    $(document).ready(function(){

        $('select[name="rental_end_date[year]"]').change(function(){
            let flag = document.getElementById("change_flag");
            flag.value = 10;
            let y = $(this).children("option:selected").val();
            let m = $('select[name="rental_end_date[month]"').children("option:selected").val();
            let d = $('select[name="rental_end_date[day]"').children("option:selected").val();
            let givenDate = y +"-"+ m + "-"+ d;
            let currentDate = new Date();
            givenDate = new Date(givenDate);
            if (givenDate > currentDate){
                var warning_div_1 = document.getElementById("warning_div");
                warning_div_1.setAttribute("style", "");
                $("#warning").text("");
            }else{
                var warning_div = document.getElementById("warning_div");
                warning_div.setAttribute("style", "background-color: #ebcccc; border-radius:5px; margin-top:10px;");
                $("#warning").text("x Your Select Date is Current Date or Before Current Date, please fix this.");
            }
        });

        $('select[name="rental_end_date[month]"]').change(function(){
            let flag = document.getElementById("change_flag");
            flag.value = 10;
            let y = $('select[name="rental_end_date[year]"').children("option:selected").val();
            let m = $('select[name="rental_end_date[month]"').children("option:selected").val();
            let d = $('select[name="rental_end_date[day]"').children("option:selected").val();

            let givenDate = y +"-"+ m + "-"+ d;
            let currentDate = new Date();
            givenDate = new Date(givenDate);
            if (givenDate > currentDate){
                var warning_div_1 = document.getElementById("warning_div");
                warning_div_1.setAttribute("style", "");
                $("#warning").text("");
            }else{
                var warning_div = document.getElementById("warning_div");
                warning_div.setAttribute("style", "background-color: #ebcccc; border-radius:5px; margin-top:10px;");
                $("#warning").text("x Your Select Date is Current Date or Before Current Date, please fix this.");
            }
        });

        $('select[name="rental_end_date[day]"]').change(function(){
            let flag = document.getElementById("change_flag");
            flag.value = 10;
            let y = $('select[name="rental_end_date[year]"').children("option:selected").val();
            let m = $('select[name="rental_end_date[month]"').children("option:selected").val();
            let d = $('select[name="rental_end_date[day]"').children("option:selected").val();

            let givenDate = y +"-"+ m + "-"+ d;
            let currentDate = new Date();
            givenDate = new Date(givenDate);
            if (givenDate > currentDate){
                var warning_div_1 = document.getElementById("warning_div");
                warning_div_1.setAttribute("style", "");
                $("#warning").text("");
            }else{
                var warning_div = document.getElementById("warning_div");
                warning_div.setAttribute("style", "background-color: #ebcccc; border-radius:5px; margin-top:10px;");
                $("#warning").text("x Your Select Date is Current Date or Before Current Date, please fix this.");
            }
        });




    });

</script>
<!-- end check date -->

<script>

    $(function(){
        // $(document).on('click', '.rm', function()
        $(document).on('click','.old', function(){
            // get the changed to data
            var $this = $(this);
            //console.log($this);
            var new_data =  $this[0].value;
            //console.log(data);
            var br_id = $(this).attr('flag');
            //console.log(br_id);
            //console.log(btn_id);
            var occu = document.getElementById('deleteflag-'+br_id).value;
            if (occu != 0){
                alert('This bed is currently used by at least a rental, you will have to wait for the rental to end, then delete the bed from this room.An alternative way is to create a new bed, then reassign that rental to that bed, then delete this bed. ');
            }


        });
    });
</script>

<script>
    $(document).ready(function(){
        var i_input = document.getElementById('i');
        var i = document.getElementById('i').value;
        var id_counter = 0;
        // add a bed
        $('#add_bed').click(function(){
            // hide no bed notification if it's being displayed
            var entries = document.getElementsByClassName('my_bed');
            if (entries.length === 0){
                // it is being displayed, hide it
                var noti = document.getElementById('ori');
                noti.setAttribute('style', 'padding-left:10px; color:red; display:none;');
            }
            // end hide no bed noti

            // add bed entry
            // format selection
            // create hidden oldID field for controller to know when to add
            //$('beds').append('<input type="hidden" class="oldID" value="null'+'">');

            var b_array = <?php echo json_encode($b_array); ?>;
            var sel = '';
            for (var j=0; j<b_array.length; j++){
                if (j===0){
                    sel = sel + '<option value="' + b_array[j][0] + '" selected="selected">'+b_array[j][1]+'</option>';
                }else{
                    sel = sel + '<option value="' + b_array[j][0] + '">'+b_array[j][1]+'</option>';
                }
            }
            $('#beds').append('<div class="my_bed" style="padding-left:10px;" id="entry'+i+'">' +
                '<a value="'+i+'"class="btn btn-danger btn-small inline_field rm" style="padding:5px; margin-bottom: 3px; margin-right:3px;" id='+i+'><p class="fas fa-minus inline_field" style="margin-bottom:0;"></p></a>' +
                '<select name="beds[add]['+ id_counter +']" class="inline_field" style="height:35px;">' +
                sel +
                '</select>' +
                '<br><br></div>');
            $('#'+i).append( '<input type="hidden" id="deleteflag-'+i+'" value="0">');
            id_counter += 1;

            // increment i
            i_input.setAttribute('value', parseInt(i)+1);
        });
        // remove a bed
        $(document).on('click', '.rm', function(){
            //console.log($(this));
            var btn_id = $(this).attr('id');
            var br_id = $(this).attr('value');
            //console.log(br_id);
            //console.log(btn_id);
            var occu = document.getElementById('deleteflag-'+br_id).value;
            // check if this is the last bed left
            var bed_num = document.getElementsByClassName("my_bed").length;
            if (bed_num == 1){
                alert("You cannot remove this bed, the room should at least have one bed recorded");
                return false;
            }
            // if the bed to be removed is not occupied by any rental
            if (occu == 0){
                // remove
                var this_class = document.getElementById('entry'+btn_id).className;
                var j_input = document.getElementById('j');
                var j = document.getElementById('j').value;
                console.log(j);
                //return false;
                if (this_class.includes('old')){                                                                         // deleting a stored entry
                  // alert('herer');
                    var room_bed_id = document.getElementById('beds[old]['+btn_id+'][1]').value;
                    //alert(room_bed_id);

                    $('#deleted').append('<input name="beds[delete]['+j+']" type="hidden" value='+room_bed_id+'>');
                    j_input.setAttribute('value', parseInt(j)+1)
                }
                //console.log(this_class);
               $("#entry"+btn_id).remove();
                var entries = document.getElementsByClassName('my_bed');
                if (entries.length === 0){
                    // it is being displayed, hide it
                    var noti = document.getElementById('ori');
                    noti.setAttribute('style', 'padding-left:10px; color:red; ');
                }
            }
            else{
                 alert('This bed is currently used by at least a rental, you will have to wait for the rental to end, then delete the bed from this room.An alternative way is to create a new bed, then reassign that rental to that bed, then delete this bed. ');
             }
            //console.log(occu);
        });
    });
</script>



<script>
    $.validate({});
    $.validate({
        modules : 'toggleDisabled',
        disabledFormFilter : 'myform.toggle-disabled',
        showErrorDialogs : false
    });

    /*   $('#contact_email').on('input', function(){
          var dumb = 1;
       });*/

</script>

<script>
    $(function(){
        //var $my_checkboxes = $('input[class=my_checkbox]').attr('checked');
        var $try = $('.my_checkbox:checkbox:checked');
        $try.each(function(){
            // for each checked checkbox, display its quantity field
            var $this = $(this);
            var $this_value = $this.attr("value").toString();
            var $quan_id = "items-joindata-".concat($this_value, "-quantity");
            // alert('Im here');
            $("#"+$quan_id).show();
        });
        // alert($try);
        // console.dir($try);
        // alert('first here');
        // console.dir($my_checkboxes);

        // alert("???");
        $(":checkbox").on('change', function() {
            // alert("try here");
            var $this = $(this);

            // alert($this);
            var $this_id = $this.attr("id");
            // alert($this_id);
            var $this_value = $this.attr("value").toString();
            var $quan_id = "items-joindata-".concat($this_value, "-quantity");

            if($(this).is(':checked')) {

                if ($this_id.indexOf("item") != -1){
                    // alert($quan_id);
                    $("#"+$quan_id).show();

                }
            }else{
                if ($this_id.indexOf("item") != -1){
                    $("#"+$quan_id).hide();
                    $(".form-error").hide();
                }
            }
        });



    });
</script>
