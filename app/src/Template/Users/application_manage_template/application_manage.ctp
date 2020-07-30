
<?php
/**
 * @var \App\View\AppView $this
 * @var $applications
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
    <?php $this->assign("title","NAIM Admin | Home"); ?>
</head>
<!-- end of header -->

<style>
    .dataTables_filter {
        float: right !important;
    }
</style>


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>

<!-- end of top nav bar -->


<!-- page content -->
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <h1>Users</h1>
        </div>

        <!--<ul class="pull-right">
            <?php
            echo $this->Html->link(
                'Create New Application',
                ['controller' => 'Applications', 'action' => 'add'],
                ['class' => 'button btn-large btn-success']
            );
            ?>
        </ul>

        <br>
        <br>-->
        <br>

        <div class="module">
            <!-- datatable start -->
            <table id="users" class="display table table-striped table-responsive table-bordered table-hover ">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Date Created</th>
                </tr>
                </thead>
                <?php
                foreach($username as $username){
                    $username_name = $username;
                ?>
                <tr>
                    <td>Username</td>
                    <td>
                        <?php echo  $username_name->username; ?>
                    </td>
                    <td>date</td>
                    <td>
                        <?php echo @$application->status; ?>
                    </td>
                    <td>
                        <div class="btn-box-row row-fluid">
                            <?php
                            echo $this->Form->postButton(
                                'View',
                                ['controller' => 'Applications', 'action' => 'admin_view', $application->id],
                                ['class' => 'btn btn-large span4 btn-info', 'style' => 'top:1px; bottom:3px;']
                            );
                            ?>

<!--                            The edit button seems to be misaligned because it is not a form but rather a html->link-->
                            <?php
                            echo $this->Html->link(
                                'Edit',
                                ['controller' => 'Applications', 'action' => 'admin_edit', $application->id],
                                ['class' => 'btn btn-large span4  btn-warning', 'style' => 'bottom:3px;']
                            );
                            ?>


                            <!--<?php
                             echo $this->Form->postButton(
                                 'Delete',
                                 ['controller' => 'Applications', 'action' => 'delete', $application->id],
                                 ['confirm' => 'Are you sure to delete this application?\nThe application will be deleted permanently', 'class' => 'btn btn-large span3 btn-danger',
                                     'style' => 'bottom:3px;']
                             );
                            ?>-->
                        </div>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- end of table body -->
        </div>
    </div>
</div>
<!-- end of page content -->

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->

<!-- dataTable script -->
<script>
    $(document).ready( function () {
        //need to change
        $('#app').DataTable({
            "language": {
                "emptyTable": "There is no Property stored in the system. Use the green button to create new properties."
            },
            "searching": true,
            "pageLength":10
        });
    } );


</script>
<!-- end of dataTable script -->
