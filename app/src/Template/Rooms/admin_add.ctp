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
    <title>Add Room | Admin</title>
    <?php $this->assign("title","Create Room | NAIM Admin"); ?>
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
                    ['class' => 'button btn-large btn-inverse']
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
                <li>Creat Room</li>
            </ul>
        </div>
        <br>
        <!-- header and back button -->
        <div class="inline_field">
            <h1>Creating a Bedroom</h1>
            <div class="inline_field">
                <small>On property: </small>
            </div>
            <div class="inline_field">
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
                <?php echo "<p><b style='color:black;'>".$location."</b></p>";?>
            </div>
        </div>

        <!-- Form created here -->
        <?= $this->Form->create($room) ?>
        <div class="module">
                <div class="module-head"></div>
                <div class="module-body">
                    <div class="form-horizontal row-fluid">
                      
                        <div class="upload-form">
                            <div class="control-group">
                                <div>
                                    <h4>Bedroom Information</h4>
                                </div>
                                <div style="padding-right:15px;">
                                <?php
                                echo $this->Form->control('room_name',
                                    ['label' => 'Bedroom Name', 'type' => 'text',
                                        'class' => 'span4'
                                    ]);


                                ?>
                                </div>
                                <br>
                                <div>
                                    <div class="inline_field" style="padding-right:5px;">
                                        <?php
                                        $type_list = array();
                                        $type_list[0] = "Private";
                                        $type_list[1] = "Sharing";

                                        echo $this->Form->control('room_type',
                                            ['label' => 'Room Type', 'type' => 'select', "options"=> $type_list
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

                                <br>

                                <?= $this->Form->control('property_id', ['type'=>'hidden', 'default'=>$pid]); ?>

                                <hr>

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
                                        <div style="padding-left:10px;color:red;" id="ori">
                                            **<b style="color:red;">No Beds</b> Currently Being Recorded for this room.<br><br>
                                        </div>

                                    </div>
                                    <?php
                                    $this->Form->unlockField('beds._ids');
                                    for ($i=0; $i<99; $i++){
                                        $this->Form->unlockField('beds._ids.'.$i.'');
                                    }
                                    ?>

                                   <?php
/*                                    echo $this->Form->control('room_capacity',
                                        ['label' => 'Room Capacity', 'type' => 'number',
                                            'class' => 'span4'
                                        ]);

                                    */?>
                                </div>
                                <!-- end bed Management -->

                                <hr>

                                <!-- room inventory -->
                                <div class="control-group">
                                    <!-- house inventory -->
                                    <label>Room Inventory:</label>
                                    <div class="control-group">
                                        <div class="inline_field">
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
                                            foreach($items as $item){ ?>
                                                <?php
                                                echo "<div><div class=\"inline_field\">".$this->Form->control('items'.'._ids.' .$id_array[$counter],
                                                        ['class'=>'checkbox inventory','label'=> $name_array[$counter],'type'=>'checkbox', 'value'=>$id_array[$counter]])."</div>";
                                                ?>

                                                <?php echo "<div class=\"inline_field\">".$this->Form->control('items._joinData.'. $id_array[$counter].'.quantity',
                                                        ['label' => false, 'type'=>'number', 'style'=>'width:80%; height:25px;display:none;',
                                                            'placeholder'=>'Enter quantity',
                                                            'data-validation' => 'number',
                                                            "data-validation-error-msg" => "Please enter a valid quantity, range from 1 to 99.",
                                                            'data-validation-allowing'=>'range[1;99]'
                                                            ]
                                                    )."</div></div>";
                                                ?>
                                                <?php
                                                $counter += 1;
                                            }
                                            ?>


                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                </div>


                                <!-- room description -->
                                <div class="control-group">
                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('room_general_information',
                                            ['label'=>'Room Description', 'type' => 'textarea',
                                                'class' => 'span12'
                                            ]);
                                        ?>
                                        <span class="help-inline">
                            In this section, please enter
                            anything in addition of the information you have entered or selected so far
                            (you will have a chance to upload image after you save this property)
                        </span>
                                    </div>
                                </div>
                                <!-- Property information ends -->

                            </div>
                        </div>


                </div>
            </div>
        </div>
        <!-- end of header and head button -->
        <?php echo $this->Form->button('Save New Room',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'onclick' => 'return validateBeds();'
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

<script>
    function validateBeds(){
        var beds = document.getElementsByClassName('my_bed');
        if (beds.length == 0){
            alert('Your room must at least have one bed');
            return false;
        }else{
            return confirm('Are you sure you want to save and create?');
        }
    }
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

    /*   $('#contact_email').on('input', function(){
          var dumb = 1;
       });*/

</script>

<script>
    $(document).ready(function(){
        var i = 0;
        var id_counter = 0;
        // add a bed
        $('#add_bed').click(function(){
            i++;
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
            var b_array = <?php echo json_encode($b_array); ?>;
            var sel = '';
            for (var j=0; j<b_array.length; j++){
                if (j===0){
                    sel = sel + '<option value="' + b_array[j][0] + '" selected="selected">'+b_array[j][1]+'</option>';
                }else{
                    sel = sel + '<option value="' + b_array[j][0] + '">'+b_array[j][1]+'</option>';
                }
            }
            $('#beds').append('<div class="my_bed" style=padding-left:10px; id="entry'+i+'">' +
                '<a class="btn btn-danger btn-small inline_field rm" style="padding:5px; margin-bottom: 3px; margin-right:3px;" id='+i+'><p class="fas fa-minus inline_field" style="margin-bottom:0;"></p></a>' +
                '<select name="beds[_ids]['+ id_counter +']" class="inline_field" style="height:35px;">' +
                sel +
                '</select>' +
                '<br><br></div>');
            id_counter += 1;
        });
        // remove a bed
        $(document).on('click', '.rm', function(){
            var btn_id = $(this).attr('id');
            $("#entry"+btn_id).remove();
            var entries = document.getElementsByClassName('my_bed');
            if (entries.length === 0){
                // it is being displayed, hide it
                var noti = document.getElementById('ori');
                noti.setAttribute('style', 'padding-left:10px; color:red; ');
            }
        });
    });
</script>



<script>
    $(function(){

        $(":checkbox").on('change', function() {
            var $this = $(this);
            var $this_id = $this.attr("id");
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

