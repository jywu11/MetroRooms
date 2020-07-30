<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rental[]|\Cake\Collection\CollectionInterface $rentals
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
    <title>Rentals | Admin</title>
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

    #archiveButton{
        color: white;
        background-color: dimgrey;
    }

</style>

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<div class ="wrapper">
    <div class ="container">

        <br>
        <div style="text-align: center">
            <div class="inline_field" style="">
                <h1>Rental Management</h1>
            </div>
        </div>

        <div class="tab-wrap">
            <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
            <label for="tab1">Active Rentals</label>

            <input type="radio" id="tab2" name="tabGroup1" class="tab">
            <label for="tab2" id="tab2_link">Expired Rentals</label>

            <input type="radio" id="tab3" name="tabGroup1" class="tab">
            <label for="tab3">Archived Rentals</label>

            <!--Features Management-->
            <!-- adding new feature -->

            <!-- active -->
            <div class="tab__content">
                <br>
                <div style="text-align: center">
                    <div class="inline_field" style="">
                        <h2>Active Rental Management</h2>
                    </div>
                </div>
                <br>

                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="a_rental" class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th class="col_hide">Created</th>
                                <th>Address</th>
                                <th class="col_hide">Duration</th>
                                <th>Main Contact (click to view)</th>
                                <th class="col_hide">Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($a_rentals as $rental) {
                                ?>
                                <tr>
                                    <!-- create -->
                                    <td class="col_hide">
                                        <?php
                                        $cd = $rental->create_date;
                                        echo $this->Time->format(
                                                $cd, #Your datetime variable
                                                'dd/MM/Y'               #Your custom datetime format
                                            );
                                        ?>
                                    </td>
                                    <!-- on address -->
                                    <td>
                                        <!-- edit -->
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            $p = $rental->property;
                                            $r = $rental->room;

                                            $unit = $p->house_number;
                                            $country = $p->country;
                                            $state = $p->state;
                                            $suburb = $p->suburb;
                                            $st = $p->street;
                                            $postcode = $p->postcode;
                                            $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                                            $r_name = $r->room_name;
                                            echo "<p class='inline_field'>".$addr." <b style='color:black;;'>"."&nbsp;(".$r_name.")</b></p><br>";
                                            ?>
                                        </div>
                                    </td>
                                    <!-- duration -->
                                    <td class="col_hide">
                                        <?php
                                        $sd = $rental->start_date;
                                        $ed = $rental->end_date;
                                        $sd = $this->Time->format($sd, 'dd/MM/Y');
                                        $ed = $this->Time->format($ed, 'dd/MM/Y');
                                        echo "<b style='color: black;'>".$sd."</b> to <b style='color: black;'>".$ed."</b> (".$rental->duration." months)";
                                        ?>
                                    </td>
                                    <!-- main contact -->
                                    <td>
                                        <?php
                                        $display = $rental->contact_name." (".$rental->contact_email.")";
                                        echo $this->HTML->Link(
                                                $display,
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id]
                                        );
                                        ?>
                                    </td>
                                    <!-- action -->
                                    <td class="col_hide">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id],
                                            ['escape'=>false,'class' => 'btn btn-large span4 btn-info far fa-eye',
                                                'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>
                                        <!-- edit button -->
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Edit</span>',
                                            ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        ?>

                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Archive</span>',
                                            ['controller' => 'Rentals', 'action' => 'setarchive', $rental->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to archive this Rental? ',
                                                'class' => 'btn btn-large span3 fas fa-folder',
                                                'font-family'=>'georgia',
                                                'id' => 'archiveButton',
                                                'style' => 'width:95px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']

                                        );
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>

                <div style="text-align:right; display:none;">
                    <div >
                        <button class="button btn-large btn-success" id=""  data-toggle="modal" data-target="#create_feature">Add a Feature in General</button>

                    </div>
                </div>
                <div style="text-align:right; display:none;">
                    <span>The features you added here will be available to be selected when you manage your properties and rooms.</span>
                </div>
            </div>

            <!-- expired -->
            <div class="tab__content">
                <br>
                <div style="text-align: center">
                    <div class="inline_field" style="">
                        <h2>Expired Rental Management</h2>
                    </div>
                </div>
                <br>



                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="e_rental" class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th class="col_hide">Created</th>
                                <th>Address</th>
                                <th class="col_hide">Duration</th>
                                <th>Main Contact (click to view)</th>
                                <th class="col_hide">Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($e_rentals as $rental)
                            {
                                ?>
                                <tr>
                                    <!-- create -->
                                    <td class="col_hide">
                                        <?php
                                        $cd = $rental->create_date;
                                        echo $this->Time->format(
                                                $cd, #Your datetime variable
                                                'dd/MM/Y'               #Your custom datetime format
                                            );
                                        ?>
                                    </td>
                                    <!-- on address -->
                                    <td>
                                        <!-- edit -->
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            $p = $rental->property;
                                            $r = $rental->room;

                                            $unit = $p->house_number;
                                            $country = $p->country;
                                            $state = $p->state;
                                            $suburb = $p->suburb;
                                            $st = $p->street;
                                            $postcode = $p->postcode;
                                            $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                                            $r_name = $r->room_name;
                                            echo "<p class='inline_field'>".$addr." <b style='color:black;;'>"."&nbsp;(".$r_name.")</b></p><br>";
                                            ?>
                                        </div>
                                    </td>
                                    <!-- duration -->
                                    <td class="col_hide">
                                        <?php
                                        $sd = $rental->start_date;
                                        $ed = $rental->end_date;
                                        $sd = $this->Time->format($sd, 'dd/MM/Y');
                                        $ed = $this->Time->format($ed, 'dd/MM/Y');
                                        echo "<b style='color: black;'>".$sd."</b> to <b style='color: black;'>".$ed."</b> (".$rental->duration." months)";
                                        ?>
                                    </td>
                                    <!-- main contact -->
                                    <td>
                                        <?php
                                        $display = $rental->contact_name." (".$rental->contact_email.")";
                                        echo $this->HTML->Link(
                                            $display,
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id]
                                        );
                                        ?>
                                    </td>
                                    <!-- action -->
                                    <td class="col_hide">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-info far fa-eye',
                                                'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>
                                        <!-- edit button -->
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Edit</span>',
                                            ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        ?>
                                        <?php
                                        echo $this->Form->postButton(
                                            '<span style="font-family: sans-serif"> Delete</span>',
                                            ['controller' => 'Rentals', 'action' => 'delete', $rental->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to delete this feature?\nThis action is not revertible.',
                                                'class' => 'btn btn-large span3 btn-danger fas fa-trash-alt',
                                                'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                        );
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>

                <div style="text-align:right; display:none;">
                    <div >
                        <button class="button btn-large btn-success" id=""  data-toggle="modal" data-target="#create_feature">Add a Feature in General</button>

                    </div>
                </div>
                <div style="text-align:right; display:none;">
                    <span>The features you added here will be available to be selected when you manage your properties and rooms.</span>
                </div>
            </div>

            <!-- archived -->
            <div class="tab__content">
                <br>
                <div style="text-align: center">
                    <div class="inline_field" style="">
                        <h2>Archived Rental Management</h2>
                    </div>
                </div>
                <br>

                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="d_rental" class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th class="col_hide">Created</th>
                                <th>Address</th>
                                <th class="col_hide">Duration</th>
                                <th>Main Contact (click to see)</th>
                                <th class="col_hide">Actions</th>
                            </tr>
                            </thead>

                            <?php
                            foreach ($d_rentals as $rental)
                            {
                                ?>
                                <tr>
                                    <!-- create -->
                                    <td class="col_hide">
                                        <?php
                                        $cd = $rental->create_date;
                                        echo $this->Time->format(
                                                $cd, #Your datetime variable
                                                'dd/MM/Y'               #Your custom datetime format
                                            );
                                        ?>
                                    </td>
                                    <!-- on address -->
                                    <td>
                                        <!-- edit -->
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            $p = $rental->property;
                                            $r = $rental->room;

                                            $unit = $p->house_number;
                                            $country = $p->country;
                                            $state = $p->state;
                                            $suburb = $p->suburb;
                                            $st = $p->street;
                                            $postcode = $p->postcode;
                                            $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                                            $r_name = $r->room_name;
                                            echo "<p class='inline_field'>".$addr." <b style='color:black;;'>"."&nbsp;(".$r_name.")</b></p><br>";
                                            ?>
                                        </div>
                                    </td>
                                    <!-- duration -->
                                    <td class="col_hide">
                                        <?php
                                        $sd = $rental->start_date;
                                        $ed = $rental->end_date;
                                        $sd = $this->Time->format($sd, 'dd/MM/Y');
                                        $ed = $this->Time->format($ed, 'dd/MM/Y');
                                        echo "<b style='color: black;'>".$sd."</b> to <b style='color: black;'>".$ed."</b> (".$rental->duration." months)";
                                        ?>
                                    </td>
                                    <!-- main contact -->
                                    <td >
                                        <?php
                                        $display = $rental->contact_name." (".$rental->contact_email.")";
                                        echo $this->HTML->Link(
                                            $display,
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id]
                                        );
                                        ?>
                                    </td>
                                    <!-- action -->
                                    <td class="col_hide">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Rentals', 'action' => 'view', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-info far fa-eye',
                                                'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>
                                        <!-- restore -->
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Restore</span>',
                                            ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 fas fa-folder-open',
                                                'confirm' => 'Are you sure to restore this rental? You will be directed to edit this rental, after you save the edit, the rental will be restored.',
                                                'id' => 'restoreButton',
                                                'style' => 'width:95px; border-radius: 35px; bottom:3px; margin-bottom: 5px; background-color:#00BFFF; color:white;']
                                        );
                                        ?>
                                       <!-- --><?php
/*                                        echo $this->Html->link(
                                            ' Restore',
                                            ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                                            ['class' => 'button btn-large span4 fas fa-folder-open',
                                                'id' => 'restoreButton',
                                                'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        // 'confirm' => 'You will be directed to edit this rental, after ensure all information is correct, please save in the edit mode to restore the rental. Are you sure to restore this rental?',
                                        */?>
                                        <!-- edit button -->
                                        <?php
                                       /* echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Edit</span>',
                                            ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );*/
                                        ?>
                                        <?php
                                        echo $this->Form->postButton(
                                            '<span style="font-family: sans-serif"> Delete</span>',
                                            ['controller' => 'Rentals', 'action' => 'delete', $rental->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to delete this feature?\nThis action is not revertible.',
                                                'class' => 'btn btn-large span3 btn-danger fas fa-trash-alt',
                                                'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                        );
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>

                <div style="text-align:right; display:none;">
                    <div >
                        <button class="button btn-large btn-success" id=""  data-toggle="modal" data-target="#create_feature">Add a Feature in General</button>

                    </div>
                </div>
                <div style="text-align:right; display:none;">
                    <span>The features you added here will be available to be selected when you manage your properties and rooms.</span>
                </div>
            </div>

        </div>


    </div>


</div>


<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->


<!-- data table features -->
<script>

    $(document).ready( function () {
        //need to change
        $('#a_rental').DataTable({
            "language": {
                "emptyTable": "There is no Active Rentals."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            "ordering": true
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }

        $('#a_rental_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
            }
        });
        $('#a_rental_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
            }
        });
    } );
</script>

<!-- data table features -->
<script>

    $(document).ready( function () {
        //need to change
        $('#e_rental').DataTable({
            "language": {
                "emptyTable": "There is no Expired Rentals."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            "ordering": true
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }

    } );
</script>

<!-- data table features -->
<script>

    $(document).ready( function () {
        //need to change
        $('#d_rental').DataTable({
            "language": {
                "emptyTable": "There is no Archived Rentals."
            },
            "search": {
                "smart": false,
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            "ordering": true
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }

    } );
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




