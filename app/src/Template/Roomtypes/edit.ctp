<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roomtype $roomtype
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","Edit Room Type | NAIM Admin"); ?>
</head>

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


<script src='https://kit.fontawesome.com/a076d05399.js'></script>


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
            // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
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
                    'Others',
                    ['controller' => 'Types', 'action' => 'index'],
                    ['class' => '', 'confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>Edit Room Type</li>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
        <div>
            <h1>Edit Room Type</h1>
            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Types', 'action' => 'delete', $roomtype->id],
                    ['confirm' => 'Are you sure to delete this room type?\nAll rooms having this type will be set to "No Type".\nThis action is not revertible.',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        </div>

        <?= $this->Form->create($roomtype, ['id' => 'myform']) ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <fieldset>
                            <div>
                                <?php
                                echo $this->Form->control('name', ['label' =>'Change Room Type Name', 'type' => 'text',
                                    'class' => 'span4', 'style'=> 'height:40px;', 'data-validation'=>'custom',
                                    'data-validation-regexp' => "^([A-Za-z ]+)$",
                                    'data-validation-error-msg'=> "Please enter a valid name"
                                ]);
                                ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="control-group">
                        <h4>This Room Type is included in the below Rooms</h4>
                        <div style="padding-left:15px;">
                            <?php
                            foreach ($roomtype->rooms as $r){
                                foreach ($properties as $p){
                                    if ($p->id == $r->property_id){
                                        $unit = $p->house_number;
                                        $country = $p->country;
                                        $state = $p->state;
                                        $suburb = $p->suburb;
                                        $st = $p->street;
                                        $postcode = $p->postcode;
                                        $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;

                                        $r_name = $r->room_name;
                                        echo "<p class='fas fa-bed inline_field'></p>&nbsp;<p class='inline_field'>".$r_name." "."</p><span class='inline_field'>&nbsp;in&nbsp;".$addr."</span><br>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save Room Type',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes on this Room Type for all the above Rooms?',
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

