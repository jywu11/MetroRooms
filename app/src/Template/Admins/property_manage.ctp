<!DOCTYPE html>

<?php
/**
 * @var \App\View\AppView $this
 * @var $properties
 */
?>
<head>


<!-- load DataTables formatting files -->
<?php
echo $this->Html->css('navbar.css');


echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
echo $this->Html->script('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js');
echo $this->Html->css(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.css']);
echo $this->Html->script(['https://cdn.datatables.net/v/ju/jqc-1.12.4/dt-1.10.18/b-1.5.6/b-print-1.5.6/r-2.2.2/rg-1.1.0/sc-2.0.0/sl-1.3.0/datatables.min.js']);



/*echo $this->Html->script(['https://code.jquery.com/jquery-3.3.1.js']);
echo $this->Html->script(['https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js']);
echo $this->Html->script(['https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js']);*/

?>




    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

<!-- head of the page -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <title>Properties | Admin</title>
    <?php $this->assign("title","NAIM Admin | Properties"); ?>

</head>
<!-- end of header -->

<style>
    li{
        width:190px;
    }
    .dataTables_filter {
        width:160px;
    }
    .fg-toolbar.ui-toolbar.ui-widget-header.ui-helper-clearfix.ui-coner-tl.ui-corner-tr.style{
        padding:170px;
    }

    body{
        padding:0;
        table-layout: fixed;
    }
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: left;
    }

    #archiveButton{
        color: white;
        background-color: dimgrey;
    }

    #restoreButton{
        color: white;
        background-color: deepskyblue;
    }

    #interviewButton{
        color: white;
        background-color: #ed969e;
    }

    .pending {
        background-color:#FFC600;
        padding-left:5px;
        border-radius: 5px;
    }

    .interviewing {
        background-color:#ffff00;
        padding-left:5px;
        border-radius: 5px;
    }

    .approved {
        background-color:greenyellow;
        opacity: 80%;
        padding-left:5px;
        border-radius: 5px;
    }

    .archived{
        background-color:lightgrey;
        padding-left:5px;
        border-radius: 5px;
    }

    td.nowrap {
        white-space: nowrap;
    }


</style>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>

<!-- end of top nav bar -->


<!-- page content -->
<body>
    <div class="wrapper">
        <div class="container">
            <div class="card text-center">
                <div class="card-body">
                    <div class="inline_filed">
                        <div class="content">

                            <div class="inline_field">
                                <h1>Your Existing Properties</h1>
                            </div>

                            <div class="tab-wrap">
                                <!-- tab header -->
                                <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
                                <label for="tab1">Active Property</label>

                                <input type="radio" id="tab2" name="tabGroup1" class="tab">
                                <label for="tab2">Archived Property</label>

                                <!-- active property -->
                                <div class="tab__content">
                                    <br>
                                    <br>
                                    <div style="padding-bottom:10px; padding-right:20px;">
                                    <ul class="pull-left">
                                        <?php
                                        echo $this->Html->link(
                                            'Create New Property',
                                            ['controller' => 'Admins', 'action' => 'cp'],
                                            ['class' => 'button btn-large btn-success']
                                        );
                                        ?>
                                    </ul>
                                </div>
                                    <br><br><br>
                                    <div class="module">
                                        <!-- datatable start -->
                                        <table id="prop" class="display table table-striped table-responsive table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th style="width:12%" class="col_hide">Created Date</th>
                                                <th style="width:60%">Address (click to view)</th>
                                                <th class="col_hide">Actions</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            foreach($properties as $property){
                                                $state_postcode = $property->state." ".$property->postcode;
                                                $location = $property->house_number." ".$property->street.", ".$property->suburb." "
                                                    .$state_postcode;

                                                $bedroom_num = $property->number_of_bedroom;
                                                $bathroom_num = $property->number_of_bathroom;
                                                ?>
                                                <tr>
                                                    <!-- col 1 -->
                                                    <td class="col_hide">
                                                        <?php
                                                        $cd = $property->create_date;
                                                        echo 'on '.$this->Time->format(
                                                                $cd, #Your datetime variable
                                                                'dd/MM/Y'               #Your custom datetime format
                                                            );
                                                        // HH:mm
                                                        ?>
                                                    </td>
                                                    <!--  end col 1 -->
                                                    <!-- col 2 -->
                                                    <td>
                                                        <?php
                                                        echo $this->Html->Link(
                                                            $location,
                                                            ['controller' => 'Properties', 'action' => 'adminView', $property->id],
                                                            ['escape' => false, 'class' => '', 'style' => '']
                                                        );
                                                        ?>
                                                    </td>
                                                    <!-- end col 2 -->
                                                    <!-- col 3 -->
                                                    <td class="col_hide">
                                                        <div class="btn-box-row row-fluid">
                                                            <?php
                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> View</span>',
                                                                ['controller' => 'Properties', 'action' => 'adminView', $property->id],
                                                                ['escape'=> false, 'class' => 'btn btn-large span4 btn-info far fa-eye', 'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                                            ); ?>

                                                            <?php
                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> Edit<span>',
                                                                ['controller' => 'Admins', 'action' => 'ep', $property->id],
                                                                ['escape'=> false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit', 'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                                            ); ?>

                                                            <?php


                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> Archive<span>',
                                                                ['controller' => 'Properties', 'action' => 'archive', $property->id],
                                                                ['escape'=> false, 'confirm' => 'Are you sure to archive this Property?\nIt will NOT be displayed to your potential tenants',
                                                                    'class' => 'btn btn-large span3 fas fa-folder',
                                                                    'font-family'=>'georgia',
                                                                    'id' => 'archiveButton',
                                                                    'style' => 'width:95px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']

                                                            );
                                                            // echo $this->Form->postButton(
                                                            //     'Delete',
                                                            //     ['controller' => 'Properties', 'action' => 'adminDelete', $property->id],
                                                            //     ['confirm' => 'Are you sure to delete this photo?\nThe photo will be deleted permanently', 'class' => 'btn btn-large span3 btn-danger',
                                                            //         'style' => 'bottom:3px;']
                                                            // );
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <!-- end col 3 -->
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <!-- end of table body -->
                                    </div>


                                </div>
                                <!-- end active property -->

                                <!-- archived property -->
                                <div class="tab__content">
                                    <br>
                                    <div class="module">
                                        <!-- datatable start -->
                                        <table id="a_prop" class="display table table-striped table-responsive table-bordered table-hover ">
                                            <thead>
                                            <tr>
                                                <th style="width:12%" class="col_hide">Created Date</th>
                                                <th style="width:48%">Address (click to view)</th>
                                                <th class="col_hide">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($a_properties as $property){
                                                $state_postcode = $property->state." ".$property->postcode;
                                                $location = $property->house_number." ".$property->street.", ".$property->suburb." "
                                                    .$state_postcode;

                                                $bedroom_num = $property->number_of_bedroom;
                                                $bathroom_num = $property->number_of_bathroom;
                                                ?>
                                                <tr>
                                                    <!-- col 1 -->
                                                    <td class="col_hide">
                                                        <?php
                                                        $cd = $property->create_date;
                                                        echo 'on '.$this->Time->format(
                                                                $cd, #Your datetime variable
                                                                'dd/MM/Y'               #Your custom datetime format
                                                            );
                                                        // HH:mm
                                                        ?>
                                                    </td>
                                                    <!--  end col 1 -->
                                                    <td>
                                                        <?php
                                                        echo $this->Html->Link(
                                                            $location,
                                                            ['controller' => 'Properties', 'action' => 'adminView', $property->id],
                                                            ['escape' => false, 'class' => '', 'style' => '']
                                                        );
                                                        ?>
                                                    </td>
                                                    <td class="col_hide">
                                                        <div class="btn-box-row row-fluid">
                                                            <?php
                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> View</span>',
                                                                ['controller' => 'Properties', 'action' => 'adminView', $property->id],
                                                                ['escape'=> false, 'class' => 'btn btn-large span4 btn-info far fa-eye', 'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                                            ); ?>
                                                            <?php
                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> Edit<span>',
                                                                ['controller' => 'Admins', 'action' => 'ep', $property->id],
                                                                ['escape'=> false, 'class' => 'btn btn-large span4  btn-warning fas fa-edit',
                                                                    'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']

                                                            ); ?>
                                                            <?php
                                                            echo $this->Html->Link(
                                                                '<span style="font-family: sans-serif"> Restore<span>',
                                                                ['controller' => 'Properties', 'action' => 'restore', $property->id],
                                                                ['escape'=> false, 'class' => 'btn btn-large span3 fas fa-folder-open',
                                                                    'confirm' => 'Are you sure to restore this Property?\nIt will be displayed to your potential tenants.',
                                                                    'id' => 'restoreButton',
                                                                    'style' => 'width:95px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                                            );
                                                            ?>
                                                            <?php
                                                            echo $this->Form->postButton(
                                                                '<span style="font-family: sans-serif"> Delete<span>',
                                                                ['controller' => 'Properties', 'action' => 'admin_delete', $property->id],
                                                                ['escape'=> false, 'confirm' => 'All non-active rentals and application placed on this property will ALSO be deleted.\nThis property will be deleted forever and you CANNOT undo the action.\nAre you sure to delete this Property?',
                                                                    'class' => 'btn btn-large span3 btn-danger fas fa-trash-alt',
                                                                    'style' => 'width:90px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                                            );
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <!-- end of table body -->

                                    </div>


                                </div>
                                <!-- end archived property -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- end of page content -->

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>

<script>
    $(function(){

    });

</script>


<script>
    if (windowWidth < 500) {
            header.classList.add("li");
        } else {
            header.classList.remove("li");
        }

</script>


<!-- dataTable script -->
<script>
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            var ukDatea = a.split('/');
            return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
        },

        "date-uk-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );

    $(document).ready( function () {
        $('#prop').DataTable({
            responsive: true,
            "aoColumns": [
                { "sType": "date-uk" },
                null,
                null
            ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Active Property. Use the green button to create new properties."
            },
            "searching": true,
            "bLengthChange": false,
            "order":[[0, "desc"]]
        });

        // onload hide table column, after data table defination
        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }
    } );
    // "pageLength":8,  responsive: false,
</script>

<script>
    $(function(){

    });
</script>

<script>
    $(document).ready( function () {
        $('#a_prop').DataTable({
            responsive: true,
            "aoColumns": [
                { "sType": "date-uk" },
                null,
                null
            ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Archived Property."
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            "order": [[ 0, "desc" ]]
        });

        // onload hide table column, after data table defination
        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }
        $('#a_prop_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
            }
        });
        $('#a_prop_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
            }
        });
        $('#prop_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
            }
        });
        $('#prop_previous').click(function(){
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
<!-- end of dataTable script -->




