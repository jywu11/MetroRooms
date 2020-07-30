<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Type[]|\Cake\Collection\CollectionInterface $types
 */
?>



<?php
/**
 * @var \App\View\AppView $this
 * @var $properties
 */
?>

<!-- load DataTables formatting files -->
<?php
echo $this->Html->css('navbar.css');
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);
?>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<!-- jquery ui dialog -->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->
<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Others | Admin</title>
    <?php $this->assign("title","NAIM Admin | Content Management"); ?>
</head>
<!-- end of header -->

<style>
    .inline_field{
        display: inline-block;
    }

    li{
        width:250px;
    }

    body{
        padding:0;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: left;
    }
    ul.breadcrumb {
        padding: 10px;
        list-style: none;
        background-color: #f4f4f4;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 0;
        color: black;
        content: "|";
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



<div class ="wrapper">
    <div class ="container">
        <div class="tab-wrap">
            <!--<input type="radio" id="tab1" name="tabGroup1" class="tab" onclick="window.location='../features';">-->
            <input type="radio" id="tab1" name="tabGroup1" class="tab" onclick="window.location='features';">
            <label for="tab1">Feature Content</label>

            <!--<input type="radio" id="tab2" name="tabGroup1" class="tab" onclick="window.location='../items';">-->
            <input type="radio" id="tab2" name="tabGroup1" class="tab" onclick="window.location='items';">
            <label for="tab2" id="tab2_link">Item Content</label>

            <input type="radio" id="tab3" name="tabGroup1" class="tab" checked>
            <label for="tab3">Others</label>

            <!--Features Management-->
            <!-- adding new feature -->

            <div class="tab__content"></div>
            <div class="tab__content"></div>

            <!-- existing types -->
            <div class="tab__content">
                <br>
                <div style="text-align: center">
                    <div class="inline_field" style="">
                        <h2>Other Content</h2>
                    </div>
                </div>
                <br>
                <div style="text-align:center;">
                    <ul class="breadcrumb inline_field" >
                        <li>
                            <?php
                            echo $this->Html->link(
                                'Property Type Management',
                                '#house_type',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                           echo $this->Html->link(
                                'Bed Type Management',
                                '#beds',
                                [
                                    'class' => '']
                            );
                            ?>
                        </li>
                    </ul>
                </div>
                <hr id="house_type">

                <!-- section title and add button -->
                <br>
                <div>
                    <h3>Property Type Management</h3>
                </div>
                <br>
                <button class="button btn-large btn-success" id=""  data-toggle="modal" data-target="#create_feature" style="margin-bottom: 5px; ">Add a Property Type in General</button>
                <br>
                <span>The property type added here will be available to be selected when you manage your properties.</span>
                <br><br>
                <!-- end section title and add button -->

                <!-- section content -->
                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="type" class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>Property Type Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($types as $type)
                            {
                                if ($type->name != 'No Type'){
                                ?>
                                <tr>
                                    <td><?php echo $type->name; ?></td>
                                    <td>
                                        <!-- edit -->
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            echo $this->Html->Link(
                                                '<span style="font-family: sans-serif"> Edit</span>',
                                                ['controller' => 'Types', 'action' => 'edit', $type->id],
                                                ['escape'=>false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                    'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px;margin-bottom:5px;']
                                            );
                                            ?>
                                            <?php
                                            echo $this->Form->postButton(
                                                '<span style="font-family: sans-serif"> Delete</span>',
                                                ['controller' => 'Types', 'action' => 'delete', $type->id],
                                                ['confirm' => 'Are you sure to delete this property type?\nAll properties having this type will be set to "No Type".\nThis action is not revertible.',
                                                    'class' => 'btn btn-large span3 btn-danger fas fa-trash-alt',
                                                    'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                            );
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                            } ?>
                        </table>
                    </div>
                </div>

                <br>
                <hr id="beds">

                <!-- section title and add button -->
                <br>
                <div>
                    <h3>Bed Type Management</h3>
                </div>
                <br>
                <button class="button btn-large btn-success" id=""  data-toggle="modal" data-target="#create_bed" style="margin-bottom: 5px; ">Add a Bed Type in General</button>
                <br>
                <span>The bed type added here will be available to be added when you manage your rooms.</span>
                <br><br>
                <!-- end section title and add button -->

                <!-- section content -->
                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="bed" class="display table table-striped table-hover ">
                            <thead>
                            <tr>
                                <th>Bed Type Name</th>
                                <th>Bed Capacity</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($beds as $bed)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $bed->bed_name; ?></td>
                                    <td><?php echo $bed->capacity; ?></td>
                                    <td>
                                        <!-- edit -->
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            echo $this->Html->Link(
                                                '<span style="font-family: sans-serif"> Edit</span>',
                                                ['controller' => 'Beds', 'action' => 'edit', $bed->id],
                                                ['escape'=>false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                    'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom:5px;']
                                            );
                                            ?>
                                            <?php
                                            echo $this->Form->postButton(
                                                '<span style="font-family: sans-serif"> Delete</span>',
                                                ['controller' => 'Beds', 'action' => 'delete', $bed->id],
                                                ['confirm' => 'The bed will be removed from all Bedrooms that are containing it, do you wish to proceed?\nThis action is not revertible.',
                                                        'class' => 'btn btn-large span3 btn-danger fas fa-trash-alt',
                                                    'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                            );
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php

                            } ?>
                        </table>
                    </div>
                </div>

                <!-- end bed type management -->
                <br>

            </div>
        </div>
    </div>
</div>


<!-- Modal House Type ADD -->
<div class="modal fade" id="create_feature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-backdrop="" style="display:none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:10px; padding-top:10px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle" style="text-align:center">Add a Property Type in General</h3>
                <div style="text-align:center">
                    <span>The property type added here will be available to be selected when you manage your properties.</span>
                </div>
            </div>

            <div class="modal-body">
                <?php echo $this->Form->create('Type', ['url' => '/types/add']) ?>
                <fieldset>
                    <div style=" text-align:center">
                        <?php
                        echo $this->Form->control('name',
                            ['label'=>'Property Type Name',
                                'type' => 'text',
                                'required' => 'required',
                                'class' => 'span4',
                                'style'=>'height:40px;',
                                'data-validation' => 'custom',
                                'data-validation-error-msg' => "Please enter a valid property type name. Possible format: 'Apartment'.",
                                'data-validation-regexp' => "^([A-Za-z ]+)$"]);
                        ?>
                    </div>
                </fieldset>

            </div>
            <div class="modal-footer" style="padding-bottom: 0;">
                <button type="button" class="button btn-inverse btn-large" data-dismiss="modal">Close</button>
                <button type="submit" class="button btn-success btn-large">Add this Property Type</button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>



<!-- Modal Bed Type ADD -->
<div class="modal fade" id="create_bed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  data-backdrop="" style="display:none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:10px; padding-top:10px;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle" style="text-align:center">Add a Bed Type in General</h3>
                <div style="text-align:center">
                    <span>The bed type added here will be available to be added when you manage your rooms.</span>
                </div>
            </div>

            <div class="modal-body">
                <?php echo $this->Form->create('Bed', ['url' => '/beds/add']) ?>
                <fieldset>
                    <div style=" text-align:center">
                        <?php
                        echo $this->Form->control('bed_name',
                            ['label'=>'Bed Type Name',
                                'type' => 'text',
                                'required' => 'required',
                                'class' => 'span4',
                                'style'=>'height:40px;',
                                'data-validation' => 'custom',
                                'data-validation-error-msg' => "Please enter a valid bed type name. Possible format: 'Single Bed'.",
                                'data-validation-regexp' => "^([A-Za-z ]+)$"]);
                        ?>
                    </div>
                    <div style=" text-align:center">
                        <?php
                        echo $this->Form->control('capacity',
                            ['label'=>'Bed Capacity',
                                'type' => 'number',
                                'required' => 'required',
                                'class' => 'span4',
                                'style'=>'height:40px;',
                                'data-validation' => 'number',
                                'data-validation-error-msg' => "Please enter a valid bed capacity.The accepted range is 1 to 9.",
                                'data-validation-allowing'=>"range[1;9]"]);
                        ?>
                    </div>
                </fieldset>

            </div>
            <div class="modal-footer" style="padding-bottom: 0;">
                <button type="button" class="button btn-inverse btn-large" data-dismiss="modal">Close</button>
                <button type="submit" class="button btn-success btn-large">Add this Bed Type</button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>



<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->


<!-- hide popup-->
<script>
    $("button").click(function(e){
        var idClicked = e.target.id;
        if (idClicked.includes("edit_feature") == true){
            var add_p = document.getElementById("create_feature");
            add_p.setAttribute("style", "");
        }
        if (idClicked.includes("create_room_type") == true){
            var add_r = document.getElementById("create_room_type");
            add_r.setAttribute("style", "");
        }
    });
</script>


<!-- format url -->
<script>
    $(document).ready(function(){
        window.onload = function(){
            var tab1 = document.getElementById("tab1");
            var tab2 = document.getElementById("tab2");

            var my_url = window.location.href;
            if (my_url.includes("types/")){
                //alert("here index");
                tab2.setAttribute("onclick", "window.location='item';");
                tab1.setAttribute("onclick", "window.location='feature';");
            }else{
                //alert("here no index");
                tab2.setAttribute("onclick", "window.location='items/index';");
                tab1.setAttribute("onclick", "window.location='features/index';");
            }
        };
    });

</script>
<!-- end format url -->

<!-- data table p type-->
<script>

    $(document).ready( function () {
        //need to change
        $('#type').DataTable({
            "language": {
                "emptyTable": "There is no Property Type currently being stored."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            responsive: true,
            "ordering": false
        });
    } );
</script>


<!-- data table p type-->
<script>

    $(document).ready( function () {
        //need to change
        $('#bed').DataTable({
            "language": {
                "emptyTable": "There is no Property Type currently being stored."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            //responsive: true,
            "ordering": false
        });
    } );
</script>

<script>

  /*  $(document).ready( function () {
        //need to change
        $('#bed').DataTable({
            "language": {
                "emptyTable": "There is no Bed Type currently being stored."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            responsive: true,
            "ordering": false
        });
    } );*/
</script>


<!-- validation -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<!-- data validation -->
<script>
    $.validate({});
    /*$.validate({

        modules : 'toggleDisabled',
        disabledFormFilter : 'toggle-disabled',
        showErrorDialogs : false
    });*/
</script>
<!-- end data validation -->


<!--  edit POPUP jquery - not used -->
<!--<script>
    // generate modal
    $("button").click(function(e){
        var idClicked = e.target.id;
        //alert(idClicked);
        if (idClicked.includes('THISISEDITMODAL') == true){
           // auto submit id and name
            var frm = document.getElementById('this_one');
            alert("here");

            // JAS ERROR
            alert('test');
            document.forms["this_one"].submit();
            $('#this_one').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url : $(this).attr('/features/') || window.location.pathname,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#form_output").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {

                    }
                });
            });

            alert("herea");









            // alert(idClicked);
            var d = idClicked.split('.');
            var id = d[0];
            var name = d[1];

            /*var modal = document.getElementById("edit_feature");
            modal.setAttribute("class", "model fade in");
            modal.setAttribute("aria-hidden", "false");*/

            var ref = document.getElementById("e_f");
            ref.setAttribute("action", "/features/edit/"+id);


            var fs_1 = document.createElement("fieldset");

            var div_7 = document.createElement("div");
            div_7.setAttribute("class", "input text required");

           /* var label_1 = document.createElement("label");
            label_1.setAttribute("for", "name");
            label_1.innerHTML = "Feature Name";
*/
            //var in_1 = document.createElement("input");
            var in_1 = document.getElementById("cur");
           /* in_1.setAttribute("type", "text");
            in_1.setAttribute("name", "name");
            in_1.setAttribute("required", "required");
            in_1.setAttribute("maxlength", "30");
            in_1.setAttribute("id", "name");*/
            in_1.setAttribute("value", name);
            /*in_1.setAttribute("class", "span3 cur_c_re");
            in_1.setAttribute("style", "height:40px;");*/

           // div_7.appendChild(label_1);
            //div_7.appendChild(in_1);
            //fs_1.appendChild(div_7);

           // ref.appendChild(fs_1);







            var but_3 = document.getElementById("but_3");
          //  var but_3 = document.createElement("button");
           // but_3.setAttribute("type", "submit");
           // but_3.innerHTML = "Save this Feature";
            but_3.setAttribute("action", "features/edit/"+id);
          //  but_3.setAttribute("class", "button btn-success btn-large");
          //  but_3.setAttribute("id", "cur_3");



        /*var but_2 = document.createElement("button");
        but_2.setAttribute("type", "button");
        but_2.setAttribute("class", "button btn-inverse btn-large");
        but_2.setAttribute("data-dismiss", "modal");
        but_2.setAttribute("id", "cur_2");
        but_2.innerHTML = "Close";*/



            //ref.appendChild(but_2);
          //  ref.appendChild(but_3);







            /*var form_1 = document.createElement("form");
            form_1.setAttribute("method", "post");
            form_1.setAttribute("accept-charset", "utf-8");
            form_1.setAttribute("action", "/features/edit/"+id);
            form_1.setAttribute("id", "cur");


*/
          /*
            form_1.appendChild(fs_1);*/

            /*var div_8 = document.createElement("div");
            div_8.setAttribute("class", "modal-footer");
            div_8.setAttribute("style", "padding-bottom:0;");



            div_8.appendChild(but_2);
            div_8.appendChild(but_3);

            form_1.appendChild(div_8);

            ref.appendChild(form_1);
*/
            //var sub_ref = document.getElementById("sub_ref");


            /*var but_3 = document.createElement("button");
            but_3.setAttribute("type", "submit");
            but_3.innerHTML = "Save this Feature";
            // but_3.setAttribute("action", "features/edit/"+id);
            but_3.setAttribute("class", "button btn-success btn-large");*/










        }
    });

    /*   var div_1 = document.createElement("div");
          div_1.setAttribute('class', 'modal fade');
          div_1.setAttribute('id', 'edit_feature');
          div_1.setAttribute('tabindex', '-1');
          div_1.setAttribute('role', 'dialog');
          div_1.setAttribute('aria-labelledby', 'exampleModalCenterTitle');
          div_1.setAttribute('aria-hidden', 'true');
          div_1.setAttribute('data-backdrop', '');

          var div_2 = document.createElement("div");
          div_2.setAttribute('class', 'modal-dialog modal-dialog-centered');
          div_2.setAttribute('role', 'document');

          var div_3 = document.createElement("div");
          div_3.setAttribute('class', 'modal-content');

          var but_1 = document.createElement("button");
          but_1.setAttribute('type', 'button');
          but_1.setAttribute('class', 'close');
          but_1.setAttribute('data-dismiss', 'modal');
          but_1.setAttribute('aria-label', 'Close');
          but_1.setAttribute('style', 'padding-right:10px; padding-top:10px;');

          var span_1 = document.createElement("span");
          span_1.setAttribute('aria-hidden', 'true');
          span_1.innerHTML = "&times;";

          var div_4 = document.createElement("div");
          div_4.setAttribute('class', 'modal-header');

          var h3_1 = document.createElement("h3");
          h3_1.setAttribute('class', 'modal-title');
          h3_1.setAttribute('id', 'exampleModalLongTitle');
          h3_1.setAttribute('style', 'text-align:center;');
          h3_1.innerHTML = "Edit Feature Name";

          var div_5 = document.createElement("div");
          div_5.setAttribute('style', 'text-align:center');

          var span_2 = document.createElement("span");
          span_2.innerHTML = "The name of the feature will be changed in general.";

          var div_6 = document.createElement("div");
          div_6.setAttribute("class", "modal-body");
          div_6.setAttribute("style", "text-align:center;");

          var form_1 = document.createElement("form");
          form_1.setAttribute("method", "post");
          form_1.setAttribute("accept-charset", "utf-8");
          form_1.setAttribute("action", "/features/edit/"+id);

          var fs_1 = document.createElement("fieldset");

          var div_7 = document.createElement("div");
          div_7.setAttribute("class", "input text required");

          var label_1 = document.createElement("label");
          label_1.setAttribute("for", "name");
          label_1.innerHTML = "\"Feature Name\" ::after";

          var in_1 = document.createElement("input");
          in_1.setAttribute("type", "text");
          in_1.setAttribute("name", "name");
          in_1.setAttribute("required", "required");
          in_1.setAttribute("maxlength", "30");
          in_1.setAttribute("id", "name");
          in_1.setAttribute("value", name);


          var div_8 = document.createElement("div");
          div_8.setAttribute("class", "modal-footer");
          div_8.setAttribute("style", "padding-bottom:0;");

          var but_2 = document.createElement("button");
          but_2.setAttribute("type", "button");
          but_2.setAttribute("class", "button btn-inverse btn-large");
          but_2.setAttribute("data-dismiss", "modal");
          but_2.innerHTML = "Close";

          var but_3 = document.createElement("button");
          but_3.setAttribute("type", "submit");
          but_3.innerHTML = "Save this Feature";
          but_3.setAttribute("action", "features/edit/"+id);
          but_3.setAttribute("class", "button btn-success btn-large");


          div_8.appendChild(but_2);
          div_8.appendChild(but_3);

          div_7.appendChild(label_1);
          div_7.appendChild(in_1);
          fs_1.appendChild(div_7);
          form_1.appendChild(fs_1);
          div_6.appendChild(form_1);

          div_5.appendChild(span_2);
          div_4.appendChild(h3);
          div_4.appendChild(div_5);

          but_1.appendChild(span_1);

          div_3.appendChild.appendChild(but_1);
          div_3.appendChild.appendChild(div_4);
          div_3.appendChild.appendChild(div_6);
          div_3.appendChild.appendChild(div_8);

          div_2.appendChild(div_3);

          div_1.append(div_2);*/
</script>
-->

