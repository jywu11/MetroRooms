
<?php
/**
 * @var \App\View\AppView $this
 * @var $users
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


<script src='https://kit.fontawesome.com/a076d05399.js'></script>


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
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <h1>Users</h1>
        </div>

        <!--<ul class="pull-right">
            <?php
            echo $this->Html->link(
                'Create New Users',
                ['controller' => 'Users', 'action' => 'add'],
                ['class' => 'button btn-large btn-success']
            );
            ?>
        </ul>

        <br>
        <br>-->
        <br>

        <?php
        foreach($users as $username){
        $username_name = $username;
        ?>

        <div class="module">
            <!-- datatable start -->
            <table id="user" class="display table table-striped table-responsive table-bordered table-hover ">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tr>
                    <td><?php echo  $username_name->username; ?></td>
                    <td><?php echo  $username_name->created ?></td>

                    <td>
                        <div class="btn-box-row row-fluid">
                            <?php
/*                            echo $this->Form->postButton(
                                'View',
                                ['controller' => 'Users', 'action' => 'view', $username_name->id],
                                ['class' => 'btn btn-large span4 btn-info', 'style' => 'top:1px; bottom:3px;']
                            );
                            */?>

<!--                            The edit button seems to be misaligned because it is not a form but rather a html->link-->
                            <?php
                            echo $this->Form->postButton(
                                'Edit',
                                ['controller' => 'Users', 'action' => 'edit', $username_name->id],
                                ['class' => 'btn btn-large span4  btn-warning fas fa-edit', 'style' => 'width:75px; top:1px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                            ); ?>


                            <!--<?php
                             echo $this->Form->postButton(
                                 'Delete',
                                 ['controller' => 'Users', 'action' => 'delete', $username_name->id],
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
        $('#user').DataTable({
            "language": {
                "emptyTable": "There is no Property stored in the system. Use the green button to create new properties."
            },
            "searching": true,
            "bLengthChange": false,
            "pageLength":8
        });
    } );


</script>
<!-- end of dataTable script -->
