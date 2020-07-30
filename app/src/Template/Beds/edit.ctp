<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq $faq
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bed | Admin</title>
    <?php $this->assign("title","Edit Bed | NAIM Admin"); ?>
</head>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

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

<body>
<div class="wrapper">
    <div class="container">
        <!-- back button -->
        <ul class="pull-left inline_field" style="padding-right:10px;">
            <?php
            echo $this->Html->link(
                'Back',
                ['controller' => 'Types', 'action' => 'index'],
                ['confirm' => 'Are you sure to go back?\nThe changes you made will not be saved',
                    'class' => 'button btn-large btn-inverse']
            );
            ?>
        </ul>
        <!--  bread nav -->
        <ul class="breadcrumb inline_field">
            <li>
                <?php
                echo $this->Html->link(
                    'Dashboard',
                    ['controller' => 'Admins', 'action' => 'cpanel'],
                    ['class' => '', 'confirm' => 'Are you sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>
                <?php
                echo $this->Html->link(
                    'Other Content',
                    ['controller' => 'Types', 'action' => 'view'],
                    ['class' => '', 'confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>Edit Bed Type</li>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
        <div>
            <h1>Edit Bed Type</h1>
            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Beds', 'action' => 'delete', $bed->id],
                    ['confirm' => 'The bed will be removed from all Bedrooms that are containing it, do you wish to proceed?\nThis action is not revertible.',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        </div>

        <?= $this->Form->create($bed, ['id' => 'myform']) ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <fieldset>
                            <div>
                                <?php
                                echo $this->Form->control('bed_name', ['label' =>'Change Bed Type Name', 'type' => 'text',
                                    'class' => 'span4', 'style'=> '',
                                    'data-validation' => 'length alphanumeric',
                                    'data-validation-length' => 'max50',
                                    'data-validation-allowing' => " ?():,.&;/=!",
                                    'data-validation-error-msg-alphanumeric' => 'Bed Type Name should not include invalid character or be empty',
                                    'data-validation-error-msg' =>  'Bed Type Name has exceeded 50 words limit'
                                ]);
                                ?>
                            </div>
                            <br>
                            <div>
                                <?php
                                echo $this->Form->control('capacity', ['label' =>'Change Bed Type Capacity', 'type' => 'number',
                                    'class' => 'span4', 'style'=> '',
                                    'data-validation' => 'number',
                                    'data-validation-allowing' => "range[1;9]",
                                    'data-validation-error-msg' =>  'Please enter a valid bed capacity.The accepted range is 1 to 9.'
                                ]);
                                ?>
                            </div>
                        </fieldset>
                    </div>
                    <br>

                   <!--
                        <hr>
                    <div class="control-group">
                        <h4>This Bed Type is being recorded by the below Bedrooms</h4>
                    </div>
-->
                    <div style="padding-left:15px;">
                        <?php
                        // if it stores in a room that is not belong to any properties listed above
                       /* foreach ($properties as $p){
                            $flag = 0;
                            $dis_array = array();
                            $counter = 0;

                            $pro_id = $p->id;
                            $unit = $p->house_number;
                            $country = $p->country;
                            $state = $p->state;
                            $suburb = $p->suburb;
                            $st = $p->street;
                            $postcode = $p->postcode;
                            $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                            $dis_array[$counter] = "<p class='fas fa-home inline_field'></p><p class='inline_field'>&nbsp;".$addr."</p><br>";
                            $counter += 1;

                            // check if the room in this property is recording this bed
                            foreach ($rooms as $room){
                                // for each room in this p, check if this bed exist
                                $ro_id = $room->id;
                                if ($room->property_id == $pro_id){
                                    foreach ($brs as $br){
                                        if ($br->room_id == $ro_id){
                                            // this room is recording this bed
                                            $flag = 1;
                                            $dis_array[$counter] = "<span class=\"inline_field\" style=\"padding-bottom:15px;\"><?php echo \"\".$room->room_name;?></span>";
                                            $counter += 1;
                                        }
                                    }
                                }
                            }
                            // end of checking, see if to display

                            if ($flag == 1){
                                foreach ($dis_array as $e){
                                    echo $e;
                                }
                            }

                        }*/
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save Bed Type',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes on this Bed Type?',
            ]); ?>
        <?= $this->Form->end() ?>

    </div>

</div>




<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>


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
</script>
