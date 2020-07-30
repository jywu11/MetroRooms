<?php
/**
 * @var \App\View\AppView $this
 * @var --
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
    <?php $this->assign("title","Photo Management | NAIM Admin"); ?>
</head>
<!-- end of head -->


<style>
    p {
        margin: 0 0 10px;
        word-break: break-all;
    }

    .inline_field{
        display: inline-block;
    }

    .my_header{
        background: #EAFAF1;
        border-radius: 5px;
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
            <ul class="pull-left">
                <?php

                echo $this->Html->link(
                    'Back',
                    $this->request->referer($pid),
                    ['confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
                        'class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
        </div>
        <br>
        <!-- header and back button -->
        <div class="inline_field">
            <h1>Photo Management</h1>
            <div class="inline_field">
                <p>On property: </p>
            </div>
            <div class="inline_field">
                <?php
                foreach ($property as $p){
                    $country = $p->country;
                    $state = $p->state;
                    $suburb = $p->suburb;
                    $street = $p->street;
                    $postcode = $p->postcode;
                    $unit_num = $p->house_number;
                    $st_location = $unit_num." ".$street.", ".$suburb.", ".$state.$postcode;
                    $location = $st_location.", ".$country;
                } ?>
                <?php echo "<h4>".$location."</h4>";?>
            </div>
        </div>
        <!-- end of header and head button -->

        <br>
        <h3>Existing photos for this property</h3>

        <div class="module">
            <!-- upload image and submit button -->
            <div class="module-body">
                <div class="my_header">
                    <h3 class="my_header">&nbspPublic Area</h3>
                    <div class="form-horizontal row-fluid" style="padding-left: 8px;">
                        <div class="control-group">
                            <div class="inline_field">
                                <div class="upload-form">
                                    <div class="inline_field">
                                        <?php echo $this->Form->create($photo, ['type' => 'file']); ?>
                                        <?php
                                        echo $this->Form->control('file',
                                            ['type'=>'file', 'class'=>'form-control', 'label' => 'Choose a Photo for public area',]);
                                        ?>
                                    </div>
                                    <div class="inline_field">
                                        <?php
                                        echo $this->Form->control('room_id', ['type'=>'hidden', 'value' => null]);
                                        echo $this->Form->button(__('Submit Photo for Public Area'), ['type'=>'submit',
                                            'class'=>'btn btn-large btn-success']);
                                        ?>
                                    </div>
                                    <br>
                                    <br>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="module">
                    <div class="form-horizontal row-fluid">
                        <!-- datatable start -->
                        <table id="prop" class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>Photo name</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($propertyImages as $pi){
                                $p_name = $pi->photo_name; ?>
                                <tr>
                                    <td>
                                        <?php echo $p_name; ?>
                                    </td>
                                    <td>
                                        <div class="btn-box-row row-fluid">
                                            <?php
                                            // to view
                                            // set up image path
                                            $path = "/webroot/img/".$pi->photo_name;
                                            //$path = "img/".$pi->photo_name;

                                            echo $this->Html->link(
                                                'View',
                                                $path,
                                                ['class' => 'btn btn-large span3 btn-info', 'target' => '_blank']
                                            );
                                            ?>
                                            <?php
                                            echo $this->Form->postButton(
                                                'Delete',
                                                ['action' => 'delete', $pi->id],
                                                ['confirm' => 'Are you sure to delete this photo?\nThe photo will be deleted permanently', 'class' => 'btn btn-large span3 btn-danger',
                                                    'style' => 'bottom:3px;']
                                            );
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  end of upload image and submit burron -->

        <!-- Room Image -->
        <?php
        $counter = 1;
        foreach ($rooms as $room){
            $this_room_id = $room->id;
            ?>
            <div class="module">
                <!-- upload image and submit button -->
                <div class="module-body">
                    <div class="my_header">
                        <h3>&nbspBedroom <?php echo $counter." (".$room->room_type.")"; ?></h3>
                        <div style="padding-bottom: 0;padding-left: 8px;">
                            <p style="word-break: break-all;"><?php echo $room->room_general_information;?></p>
                        </div>
                        <div class="form-horizontal row-fluid" style="padding-left: 8px;">
                            <div class="control-group">
                                <div class="inline_field">
                                    <div class="upload-form">
                                        <div class="inline_field">
                                            <?php echo $this->Form->create($photo, ['type' => 'file']); ?>
                                            <?php
                                            $my_label = "Choose a Photo for bedroom ".$counter;
                                            echo $this->Form->control('file',
                                                ['type'=>'file', 'class'=>'form-control', 'label' => $my_label]);
                                            ?>
                                            <?php $counter += 1; ?>
                                        </div>
                                        <div class="inline_field">
                                            <?php
                                            echo $this->Form->control('room_id', ['type'=>'hidden', 'value' => $this_room_id]);
                                            echo $this->Form->button(__('Submit Photo for this Room'), ['type'=>'submit',
                                                'class'=>'btn btn-large btn-success']);
                                            ?>
                                        </div>
                                        <br>
                                        <br>
                                        <?php echo $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="module">
                        <div class="form-horizontal row-fluid">
                            <!-- datatable start -->
                            <?php $tid = "br".$counter; ?>
                            <table id=<?php echo $tid; ?> class="display table table-striped table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>Photo name</th>
                                <th>Operations</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            foreach ($propertyImages as $pi){
                                $counter = 0;
                                if ($pi->room_id == $this_room_id){
                                    $counter += 1;
                                    $p_name = $pi->photo_name; ?>
                                    <tr>
                                        <td>
                                            <?php echo $p_name; ?>
                                        </td>
                                        <td>
                                            <div class="btn-box-row row-fluid">
                                                <?php
                                                // to view
                                                // set up image path
                                                $path = "/webroot/img/".$pi->photo_name;
                                                //$path = "img/".$pi->photo_name;

                                                echo $this->Html->link(
                                                    'View',
                                                    $path,
                                                    ['class' => 'btn btn-large span3 btn-info', 'target' => '_blank']
                                                );
                                                ?>
                                                <?php
                                                echo $this->Form->postButton(
                                                    'Delete',
                                                    ['action' => 'delete', $pi->id],
                                                    ['confirm' => 'Are you sure to delete this photo?\nThe photo will be deleted permanently', 'class' => 'btn btn-large span3 btn-danger',
                                                        'style' => 'bottom:3px;']
                                                );
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ($counter == 0){
                                    echo "<tr>This bedroom has no photo</tr>";
                                }
                            } ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>

        <!--  edn of photo list -->

    </div>
</div>


<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->


<!-- dataTable script -->
<script>
    $(document).ready( function () {
        jQuery('table').each(function() {
            var $this_id = this.id;
            var $t_id = "#".concat($this_id);

            // alert($t_id);
            $($t_id).DataTable({
                "language": {
                    "emptyTable": "There is no Photo uploaded. Please choose a photo and submit it with the green button."
                },
                "searching": false,
                "bLengthChange": false,
                "bPaginate": false,
                "bInfo": false
                //"pageLength":10
            });


        });


    } );


</script>
<!-- end of dataTable script -->
