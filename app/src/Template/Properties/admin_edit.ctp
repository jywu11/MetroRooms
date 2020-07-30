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
    <title>Edit Property | Admin</title>
    <?php $this->assign("title","Edit Property | NAIM Admin"); ?>
</head>
<!-- end of head -->


<script src='https://kit.fontawesome.com/a076d05399.js'></script>


<script src="https://cdn.tiny.cloud/1/1zi0mrpc0n8ej1y390e310ybmi4bfvu7ukbwgst0rk1x6pre/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'#general-information',
        bold: [
            { inline: 'strong', remove: 'all' },
            { inline: 'span', styles: { fontWeight: '800' } },
            { inline: 'b', remove: 'all' }
        ],
    });
</script>
<script>
    tinymce.init({selector:'#parking-taxi'});
</script>
<script>
    tinymce.init({selector:'#bus-tram'});
</script>
<script>
    tinymce.init({selector:'#train'});
</script>
<script>
    tinymce.init({selector:'#surrounding'});
</script>
<script>
    tinymce.init({selector:'#houserule'});
</script>




<style>
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


</style>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->


<!-- page content -->
<div class="single-property">
<div class="wrapper">
    <div class="container">
        <div class="inline_field">

            <ul class="pull-left inline_field"  style = 'padding-right:10px;'>
                <?php
                echo $this->Html->link(
                    'Back',
                    $this->request->referer(),
                    ['confirm' => 'Are you sure to go back?\nAll your changes will not be saved', 'class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
            <ul class="breadcrumb inline_field">
                <li>
                    <?php
                    echo $this->Html->link(
                        'Dashboard',
                        ['controller' => 'Admins', 'action' => 'cpanel'],
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                                'class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Properties',
                        ['controller' => 'Admins', 'action' => 'property_manage'],
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                                'class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'View',
                        ['controller' => 'Properties', 'action' => 'admin_view', $property->id],
                        ['confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',
                            'class' => '']
                    );
                    ?>
                </li>
                <li>Edit</li>
            </ul>

        </div>


        <br>
        <div class="inline_field">
            <h1>Edit Property</h1>
        </div>

        <br>

        <!-- form begins -->
        <?php
        echo $this->Form->create($property);
        ?>
        <!-- Address Edit -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <fieldset>
                        <!-- section header -->
                        <div class="control-group">
                            <h2>Address section</h2>
                        </div>
                        <!-- section content -->
                        <div class="control-group">
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('house_number', ['label' =>'Unit/Street', 'type' => 'text',
                                    'class' => 'span9'
                                ]);
                                ?>
                                <span class="help-inline span8">The unit number of this property</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('street', ['type' => 'text',
                                    'class' => 'span9'
                                ]);
                                ?>
                                <span class="help-inline span8">The street of this property located</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('suburb', ['type' => 'text',
                                    'class' => 'span9'
                                ]);
                                ?>
                                <span class="help-inline span8">The suburb of this property</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('postcode', ['type' => 'text',
                                    'class' => 'span9', 'data-validation' => 'number length',
                                    "data-validation-length"=> 4,
                                    "data-validation-error-msg" => "Please enter a valid postcode"
                                ]);
                                ?>
                                <span class="help-inline span8">The postcode of this property</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('country', ['type' => 'text',
                                    'class' => 'span8', 'disabled' => 'disabled'
                                ]);
                                ?>
                                <span class="help-inline span8">The country this property is located</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('state', ['type' => 'text',
                                    'class' => 'span9', 'disabled' => 'disabled'
                                ]);
                                ?>
                                <span class="help-inline span8">The state code of this property</span>
                            </div>
                            <br>
                            <br>
                            <p>Note that you're not allowed change the country or the state of the property.</p>
                        </div>

                    </fieldset>
                </div>
            </div>
        </div>
        <!-- address edit ends -->

        <!-- Property information Edit -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                        <div class="control-group">
                            <h2>Details Section</h2>
                        </div>
                        <!-- property type -->
                    <div class="control-group">
                        <div class="inline_field">
                            <?php echo $this->Form->control('type_id',
                                ['label' => 'Property Type', 'type' => 'select', 'style'=> 'padding-top:0;'
                                ]); ?>
                            <span class="help-inline span12">The house type of this property</span>
                        </div>
                    </div>
                       <!-- <div class="control-group">
                            <div class="inline_field">
                                <?php /*echo $this->Form->control('type_id',
                                    ['label' => 'Property Type', 'type' => 'select',
                                    ]); */?>
                                <span class="help-inline span12">The house type of this property</span>
                            </div>
                        </div>-->
                        <!-- property room number -->
                        <div class="control-group">
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('number_of_bedroom', ['type' => 'number',
                                    'class' => 'span10', 'data-validation' => 'number',
                                    //'default' => 1,
                                    "data-validation-allowing"=>"range[1;99]",
                                    "data-validation-error-msg" => "Please enter a valid bedroom number, the valid range is from 1 to 99. "
                                ]);
                                ?>
                                <span class="help-inline span10">Bedroom number</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('number_of_bathroom', ['type' => 'number',
                                    'class' => 'span10', 'data-validation' => 'number',
                                    //'default' => 1,
                                    "data-validation-allowing"=>"range[1;99]",
                                    "data-validation-error-msg" => "Please enter a valid bathroom number, the valid range is from 1 to 99. "
                                ]);
                                ?>
                                <span class="help-inline span10">Bathroom number</span>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('number_of_toilet', ['type' => 'number',
                                    'class' => 'span10', 'data-validation' => 'number',
                                    //'default' => 1,
                                    "data-validation-allowing"=>"range[1;99]",
                                    "data-validation-error-msg" => "Please enter a valid toilet number, the valid range is from 1 to 99. "
                                ]);
                                ?>
                                <span class="help-inline span10">Toilet number</span>
                            </div>
                            <br>
                        </div>
                        <!-- proeprty feature -->
                        <div class="control-group">
                            <div class="inline_field">
                                <?php

                                echo $this->Form->control('features._ids',
                                    [
                                        'templates' => [ // try format the inline checkbox better when have time
                                            'checkboxWrapper' => '<label class="checkbox feature">{{label}}</label>',
                                        ],
                                        'multiple'=>'checkbox',
                                        'options' => $features,
                                    ]);
                                ?>
                            </div>

                            <br>
                            <br>
                        </div>


                        <!-- Public Transport and Surroundings -->
                        <div class="control-group">
                            <h4>Public Transport and Surrounding</h4>
                            <div class="inline_field resize_box" style="margin-right:10px;">
                                <?php
                                echo $this->Form->control('parking_taxi',
                                    ['label'=>'Parking and Taxis information', 'type' => 'textarea',
                                        'class' => 'span10 resize_box'
                                    ]);
                                ?>

                            </div>

                            <div class="inline_field resize_box" style="margin-right:10px;">
                                <?php
                                echo $this->Form->control('bus_tram',
                                    ['label'=>'Bus Routes and Tram Stops', 'type' => 'textarea',
                                        'class' => 'span10 '
                                    ]);
                                ?>

                            </div>

                            <div class="inline_field resize_box" style="margin-right:10px;">
                                <?php
                                echo $this->Form->control('train',
                                    ['label'=>'Train Stations', 'type' => 'textarea',
                                        'class' => 'span12'
                                    ]);
                                ?>

                            </div>

                            <div class="inline_field resize_box" style="margin-right:10px;">
                                <?php
                                echo $this->Form->control('surrounding',
                                    ['label'=>'House Surroundings', 'type' => 'textarea',
                                        'class' => 'span12 resize_box'
                                    ]);
                                ?>

                            </div>
                        </div>
                        <!-- end of public transport and surrounding -->

                        <!-- property description -->
                        <div class="control-group">
                            <h4>General House Information</h4>
                            <div>
                                <?php
                                echo $this->Form->control('houserule',
                                    ['label'=>'House Rule', 'type' => 'textarea',
                                        'class' => 'span10 ', 'style' => 'max-width:100%'
                                    ]);
                                ?>
                            </div>
                            <br>
                            <div>
                                <?php
                                echo $this->Form->control('general_information',
                                    ['label'=>'Additional Description', 'type' => 'textarea',
                                        'class' => 'span12', 'style' => 'max-width:100%'
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

                        <!-- map -->
                        <div class="control-group">
                            <h4>Map</h4>
                            <?php
                            echo $this->Form->control('map',
                                ['label'=>'Embeded Map Link', 'type' => 'textarea',
                                    'class' => 'span12'
                                ]);
                            ?>
                        </div>
                        <div id="warning_div" style="display: none;">
                            <p class="fas fa-times-circle inline_field" style="color:red; padding-left:5px;"></p><p class="inline_field" style="color:red;">&nbsp; It seems your Map Code is not in correct format. Please generate the map again and be sure to Copy the Full Code.</p>
                        </div>
                        <!-- end map -->
                </div>
            </div>
        </div>

        <!-- inventory -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <h3>House Public Inventory</h3>
                <!-- house inventory -->
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
                            $flag = 0;
                            foreach ($my_items as $my_item){
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
                                            'data-validation-allowing'=>'range[1;99]']
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
            </div>
        </div>

        <!-- image and room -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="control-group">
                    <div class="inline_field">
                        <h3>Manage Photos</h3>
                        <p>To upload photos, you need to save this property, then click to view the property, and choose 'Manage Photos' button.</p>
                    </div>
                </div>
                <div class="control-group">
                    <div class="inline_field">
                        <h3>Manage Rooms</h3>
                        <p>To manage rooms, you need to save this property, then when view the property, click 'Manage Room' button.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save All',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'id' => 'mybtn',
                'confirm' => 'Are you sure you want to save your changes?'
            ]); ?>

        <!-- form ends -->
        <?= $this->Form->end() ?>
    </div>
    <!-- container ends -->
</div>
<!-- wrapper ends -->
</div>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->


<script>
    $(document).ready(function(){
        //alert("here");
        let myMap = document.getElementsByName("map");
        myMap = myMap[0];
        //alert(myMap);

        myMap.addEventListener('input', function(){
            var inputMap = myMap.value;
            if (inputMap.includes("<iframe") && inputMap.includes("</iframe>")){
                var my_r_d = document.getElementById("warning_div");
                my_r_d.setAttribute("style", "display:none");
                document.getElementById("mybtn").disabled = false;
            }else{
                var my_d = document.getElementById("warning_div");
                my_d.setAttribute("style", "background-color: #ebcccc; border-radius:5px; margin-top:10px;");
                document.getElementById("mybtn").disabled = true;
                //alert(inputMap.length);
                if (inputMap.length == 0){
                    var my_r_d_1 = document.getElementById("warning_div");
                    my_r_d_1.setAttribute("style", "display:none");
                    document.getElementById("mybtn").disabled = false;
                }
            }
        }, true);
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

<script>
    $(document).ready(function(){
        var windowWidth = $(window).width();
        if (windowWidth < 1200) {
            var boxes = document.getElementsByClassName("resize_box");
            //alert("here");
            for(let i=0; i < boxes.length; i++){
                boxes[i].style.maxWidth = "100%";
                boxes[i].setAttribute("class", "resize_box");
                //boxes[i].setAttribute('style', 'max-width:100%');
            }
        }else{
            var boxes_1 = document.getElementsByClassName("resize_box");
            for(let i=0; i < boxes_1.length; i++){
                boxes_1[i].style.maxWidth = "";
                // boxes_1[i].setAttribute('style', '');
            }
        }

    });

</script>


<script>

    // When the user scrolls the page, execute myFunction
    $(window).on('resize', function(){
        var windowWidth = $(window).width();

        if (windowWidth < 1200) {
            var boxes = document.getElementsByClassName("resize_box");
            for(let i=0; i < boxes.length; i++){
                boxes[i].style.maxWidth = "100%";
                //boxes[i].setAttribute('style', 'max-width:100%');
            }
        }else{
            var boxes_1 = document.getElementsByClassName("resize_box");
            for(let i=0; i < boxes_1.length; i++){
                boxes_1[i].style.maxWidth = "";
                // boxes_1[i].setAttribute('style', '');
            }
        }
    });
</script>
