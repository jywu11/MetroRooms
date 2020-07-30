
<?php
/**
 * @var \App\View\AppView $this
 * @var $applications
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



<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications | Admin</title>
    <?php $this->assign("title","NAIM Admin | Application Management"); ?>

</head>
<!-- end of header -->

<style>
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

</style>



<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->


<!-- page content -->
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <h1>Expression of Interests</h1>
        </div>
        <div class="tab-wrap">
            <!-- tab header -->
            <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
            <label for="tab1">Unprocessed Application</label>

            <input type="radio" id="tab2" name="tabGroup1" class="tab">
            <label for="tab2">Interviewing Application</label>

            <input type="radio" id="tab3" name="tabGroup1" class="tab">
            <label for="tab3">Accepted Application</label>

            <input type="radio" id="tab4" name="tabGroup1" class="tab">
            <label for="tab4">Refused/Archived Application</label>

            <!-- tab header end -->

            <!-- processing -->
            <div class="tab__content">
                <br>
                <div class="module">
                    <!-- datatable start -->
                    <table id="p_app" class="display table table-striped table-responsive table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th style="width:13%;" class="col_hide">Created</th>
                            <th style="width:39%" class="col_change">on Address</th>
                            <th style="width:20%"  class="col_change">Contact(click to view)</th>
                            <th style="width:15%"  class="col_hide">Status</th>
                            <th style="width:35%"  class="col_hide">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($processing_applications as $application){
                            $property = $application->property;
                            $state = $property->state;
                            $suburb = $property->suburb;
                            $street = $property->street;
                            $postcode = $property->postcode;
                            $unit_num = $property->house_number;
                            $st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
                            $location = $st_location;
                            $room = $application->room;
                            $r_n = $room->room_name;
                            $addr = $location." (".$r_n.")";
                            ?>
                            <tr>
                                <td class="col_hide">
                                    <?php
                                    // debug($application);
                                    $cd = $application->create_date;
                                    echo 'on '.$this->Time->format(
                                            $cd, #Your datetime variable
                                            'dd/MM/Y'               #Your custom datetime format
                                        );
                                    //$cd->i18nFormat(); // outputs '4/20/14, 10:10 PM' for the en-US locale
                                    ?>

                                </td>
                                <td><?php echo $addr; ?></td>
                                <td >
                                    <?php $display = $application->contact_email." (".$application->contact_name.")";

                                    echo $this->HTML->Link(
                                            $display,
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id]
                                    );
                                    ?>
                                </td>
                                <td class="col_hide">
                                    <?php if ($application->application_status == 'p'){
                                        echo '<p class="pending">Pending</p>';
                                    } elseif($application->application_status == 'i'){
                                        echo '<p class="interviewing">Interviewing</p>';
                                    } elseif ($application->application_status == 'a'){
                                        echo '<p class="approved">Accepted</p>';
                                    } elseif($application->application_status == 'd'){
                                        echo '<p class="archived">Archived</p>';
                                    }?>
                                </td>
                                <td class="col_hide">
                                    <div class="btn-box-row row-fluid">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-info far fa-eye', 'style' => 'width:73px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>

                                        <!--                            The edit button seems to be misaligned because it is not a form but rather a html->link-->
                                        <?php
                                      /*  echo $this->Html->link(
                                            ' Edit',
                                            ['controller' => 'Applications', 'action' => 'edit', $application->id],
                                            ['class' => 'btn btn-large span4  btn-warning fas fa-edit', 'style' => 'width:75px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        // fas fa-bullhorn*/
                                        ?>

                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Interview</span>',
                                            ['controller' => 'Applications', 'action' => 'setinterview', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span3 fas fa-comment-alt',
                                                'id' => 'interviewButton',
                                                'style' => 'width:105px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
                                        );
                                        ?>


                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Refuse</span>',
                                            ['controller' => 'Applications', 'action' => 'archive', $application->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to archive this application?',
                                                'class' => 'btn btn-large span3 fas fa-folder',
                                                'id' => 'archiveButton',
                                                'style' => 'width:87px; bottom:3px; border-radius: 35px; top:1px; margin-bottom: 5px;']
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
            <!--  end processing -->

            <!-- interviewing -->
            <div class="tab__content">
                <br>
                <div class="module">
                    <!-- datatable start -->
                    <table id="i_app" class="display table table-striped table-responsive table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th style="width:13%;"  class="col_hide" >Created</th>
                            <th style="width:39%" class="col_change">on Address</th>
                            <th style="width:20%" class="col_change">Contact (click to view)</th>
                            <th style="width:15%"  class="col_hide">Status</th>
                            <th style="width:35%"  class="col_hide">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($interviewing_applications as $application){
                            $property = $application->property;
                            $state = $property->state;
                            $suburb = $property->suburb;
                            $street = $property->street;
                            $postcode = $property->postcode;
                            $unit_num = $property->house_number;
                            $st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
                            $location = $st_location;
                            $room = $application->room;
                            $r_n = $room->room_name;
                            $addr = $location." (".$r_n.")";
                            ?>
                            <tr>
                                <td class="col_hide">
                                    <?php
                                    // debug($application);
                                    $cd = $application->create_date;
                                    echo 'on '.$this->Time->format(
                                            $cd, #Your datetime variable
                                            'dd/MM/Y'            #Your custom datetime format
                                        );
                                    //$cd->i18nFormat(); // outputs '4/20/14, 10:10 PM' for the en-US locale
                                    ?>

                                </td>
                                <td><?php echo $addr; ?></td>
                                <td>
                                    <?php $display =  $application->contact_email." (".$application->contact_name.")";
                                    echo $this->HTML->Link(
                                            $display,
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id]
                                    );
                                    ?>
                                </td>
                                <td class="col_hide">
                                    <?php if ($application->application_status == 'p'){
                                        echo '<p class="pending">Pending</p>';
                                    } elseif($application->application_status == 'i'){
                                        echo '<p class="interviewing">Interviewing</p>';
                                    } elseif ($application->application_status == 'a'){
                                        echo '<p class="approved">Accepted</p>';
                                    } elseif($application->application_status == 'd'){
                                        echo '<p class="archived">Archived</p>';
                                    }?>
                                </td>
                                <td class="col_hide">
                                    <div class="btn-box-row row-fluid">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-info far fa-eye', 'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>

                                        <!--                            The edit button seems to be misaligned because it is not a form but rather a html->link-->
                                        <?php
                                       /* echo $this->Html->link(
                                            ' Edit',
                                            ['controller' => 'Applications', 'action' => 'edit', $application->id],
                                            ['class' => 'btn btn-large span4  btn-warning fas fa-edit', 'style' => 'width:75px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );*/
                                        ?>

<!--                                        --><?php
//                                        echo $this->Html->Link(
//                                            ' Accept',
//                                            ['controller' => 'Applications', 'action' => 'accept', $application->id],
//                                            ['class' => 'btn btn-large span4 btn-success fas fa-check-circle',
//                                                'confirm' => 'Are you sure to Accept this Application?',
//                                                'style' => 'width:90px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
//                                        );
//                                        ?>

                                        <?php
                                        echo $this->Html->Link(
                                           '<span style="font-family: sans-serif"> Accept</span>',
                                            ['controller' => 'Rentals', 'action' => 'add', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-success fas fa-check-circle',
                                                'confirm' => 'By Accepting this Application, a Rental will be created.\nYou will have a chance to alter the rental information.\nAre you sure to Accept this Application?',
                                                'style' => 'width:90px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        ?>

                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Refuse</span>',
                                            ['controller' => 'Applications', 'action' => 'archive', $application->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to archive this application?',
                                                'class' => 'btn btn-large span3 fas fa-folder',
                                                'id' => 'archiveButton',
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
            <!-- end interveiwing -->

            <!-- accepted -->
            <div class="tab__content">
                <br>

                <br>
                <div style="text-align: center">
                    <h3>All your Accepted Applications can only be accessed in your Rental Management</h3>
                </div>
                <br>
                <div style="text-align: center">
                    <div style="text-align: center">
                    <?php
                  echo $this->Html->link(
                        'Go To Rental Management',
                        ['controller' => 'Rentals', 'action' => 'index'],
                        ['class' => 'button btn-large btn-info',
                            'style' => 'bottom:3px; margin-bottom: 5px; text-align: center']
                    );
                    ?>
                    </div>
                </div>
               <br>
                <br>
            </div>
            <!--  end accepted -->

            <!-- archived -->
            <div class="tab__content">
                <br>
                <div class="module">
                    <!-- datatable start -->
                    <table id="archive_app" class="display table table-striped table-responsive table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th style="width:13%;" class="col_hide">Created</th>
                            <th style="width:39%" class="col_change">on Address</th>
                            <th style="width:20%"  class="col_change">Contact (click to view)</th>
                            <th style="width:15%"  class="col_hide">Status</th>
                            <th style="width:35%"  class="col_hide">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($archived_applications as $application){
                            $property = $application->property;
                            $state = $property->state;
                            $suburb = $property->suburb;
                            $street = $property->street;
                            $postcode = $property->postcode;
                            $unit_num = $property->house_number;
                            $st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
                            $location = $st_location;
                            $room = $application->room;
                            $r_n = $room->room_name;
                            $addr = $location." (".$r_n.")";
                            ?>
                            <tr>
                                <td class="col_hide">
                                    <?php
                                    // debug($application);
                                    $cd = $application->create_date;
                                    echo 'on '.$this->Time->format(
                                            $cd, #Your datetime variable
                                            'dd/MM/Y'               #Your custom datetime format
                                        );
                                    //$cd->i18nFormat(); // outputs '4/20/14, 10:10 PM' for the en-US locale
                                    ?>

                                </td>
                                <td><?php echo $addr; ?></td>
                                <td>
                                    <?php $display = $application->contact_email." (".$application->contact_name.")";
                                    echo $this->HTML->Link(
                                            $display,
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id]
                                    );
                                    ?>
                                </td>
                                <td class="col_hide">
                                    <?php if ($application->application_status == 'p'){
                                        echo '<p class="pending">Pending</p>';
                                    } elseif($application->application_status == 'i'){
                                        echo '<p class="interviewing">Interviewing</p>';
                                    } elseif ($application->application_status == 'a'){
                                        echo '<p class="approved">Accepted</p>';
                                    } elseif($application->application_status == 'd'){
                                        echo '<p class="archived">Archived</p>';
                                    }?>
                                </td>
                                <td class="col_hide">
                                    <div class="btn-box-row row-fluid">
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> View</span>',
                                            ['controller' => 'Applications', 'action' => 'admin_view', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 btn-info far fa-eye', 'style' => 'width:75px; top:1px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                                        );
                                        ?>

                                        <!--                            The edit button seems to be misaligned because it is not a form but rather a html->link-->
                                        <?php
                                        echo $this->Html->Link(
                                            '<span style="font-family: sans-serif"> Restore</span>',
                                            ['controller' => 'Applications', 'action' => 'admin_restore', $application->id],
                                            ['escape'=>false, 'class' => 'btn btn-large span4 fas fa-folder-open',
                                                'confirm' => 'Are you sure to restore this application?',
                                                'id' => 'restoreButton',
                                                'style' => 'width:95px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                                        );
                                        ?>


                                        <?php
                                        echo $this->Form->postButton(
                                            '<span style="font-family: sans-serif"> Delete</span>',
                                            ['controller' => 'Applications', 'action' => 'delete', $application->id],
                                            ['escape'=>false, 'confirm' => 'Are you sure to delete this application?\nIt will be deleted forever and you CANNOT undo the action',
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
            <!-- end archived -->

        </div><!-- end tab-warp -->
    </div><!-- end container -->
</div><!-- end wrapper -->
<!-- end of page content -->

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->

<!-- dataTable script -->
<script>
    if (windowWidth < 500) {
        header.classList.add("li");
    } else {
        header.classList.remove("li");
    }
</script>
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
        //need to change
        $('#p_app').DataTable({
            "aoColumns": [
                { "sType": "date-uk" },
                null,
                null,
                null,
                null
            ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Pending Application."
            },
            "searching": true,
            "bLengthChange": false,
            "pageLength":8,
            responsive: true,
            "order":[[0, "desc"]]
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
            let col_to_change = $(".col_change");
            for (let i=0; i < col_to_change.length; i++){
                col_to_change[i].setAttribute('style', '');
            }
        }

        $('#p_app_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });

        $('#p_app_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                    //console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });
    } );
</script>

<script>
    $(document).ready( function () {
        //need to change
        $('#i_app').DataTable({
                "aoColumns": [
                    { "sType": "date-uk" },
                    null,
                    null,
                    null,
                    null
                ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Application currently being viewed."
            },
            "searching": true,
            "pageLength":8,
            "bLengthChange": false,
            responsive: true,
            "order": [[ 0, "desc" ]]
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
              //  console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
            let col_to_change = $(".col_change");
            for (let i=0; i < col_to_change.length; i++){
                col_to_change[i].setAttribute('style', '');
            }
        }

        $('#i_app_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                   // console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });

        $('#i_app_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                  //  console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });
    } );
</script>

<script>
    $(document).ready( function () {
        //need to change
        $('#a_app').DataTable({
            "aoColumns": [
                { "sType": "date-uk" },
                null,
                null,
                null,
                null
            ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Accepted Application."
            },
            "searching": true,
            "bLengthChange": false,
            "pageLength":8,
            responsive: true,
            "order": [[ 0, "desc" ]]
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
                //console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
            let col_to_change = $(".col_change");
            for (let i=0; i < col_to_change.length; i++){
                col_to_change[i].setAttribute('style', '');
            }
        }

        $('#a_app_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                 //   console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });

        $('#a_app_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                 //   console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });
    } );


</script>

<script>
    $(document).ready( function () {
        //need to change
        $('#archive_app').DataTable({
            "aoColumns": [
                { "sType": "date-uk" },
                null,
                null,
                null,
                null
            ],
            "search": {
                "smart": false,
            },
            "language": {
                "emptyTable": "There is no Archived Application."
            },
            "searching": true,
            "bLengthChange": false,
            "pageLength":8,
            responsive: true,
            "order": [[ 0, "desc" ]]
        });

        if ($(window).width() < 1200) {
            let col_to_hide = $(".col_hide");
            for (let i=0; i < col_to_hide.length; i++){
               // console.log(col_to_hide[i]);
                col_to_hide[i].setAttribute('style', 'display: none;');
            }
        }

        $('#archive_app_next').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                   // console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });

        $('#archive_app_previous').click(function(){
            if ($(window).width() < 1200) {
                let col_to_hide = $(".col_hide");
                for (let i=0; i < col_to_hide.length; i++){
                   // console.log(col_to_hide[i]);
                    col_to_hide[i].setAttribute('style', 'display: none;');
                }
                let col_to_change = $(".col_change");
                for (let i=0; i < col_to_change.length; i++){
                    col_to_change[i].setAttribute('style', '');
                }
            }
        });
    } );
</script>

<!-- end of dataTable script -->
