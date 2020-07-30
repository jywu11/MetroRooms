<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>

<?php
$username = $this->Session->read('Auth.User.username');
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","Edit Feature | NAIM Admin"); ?>
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
                ['controller' => 'Features', 'action' => 'index'],
                ['confirm' => 'Are you sure to go back?\nThe changes you made will not be saved',
                    'class' => 'button btn-large btn-inverse']
            );
            // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
            ?>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Manage Your Account: '.$username) ?></legend>
            <?php
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            ?>
        </fieldset>
        <div class="inline_field">
            <ul class="pull-left">
                <?php
                echo $this->Html->link(
                    'Back',
                    $this->request->referer()
                );
                ?>
        <div>
            <h1>Edit Feature</h1>
            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Features', 'action' => 'delete', $feature->id],
                    ['confirm' => 'Are you sure to delete this Feature?\nIt will be deleted forever from all the properties that are recording it.\nYou CANNOT undo the action',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        </div>

        <?= $this->Form->create($feature, ['id' => 'myform']) ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <fieldset>
                            <div>
                                <?php
                                echo $this->Form->control('name', ['label' =>'Change Feature Name', 'type' => 'text',
                                    'class' => 'span4', 'style'=> 'height:40px;', 'data-validation'=>'custom',
                                    'data-validation-regexp' => "^([A-Za-z ]+)$",
                                    'data-validation-error-msg'=> "Please enter a valid name"
                                ]);
                                ?>

                                <?= $this->Form->create($user) ?>
                                <fieldset>
                                    <legend><?= __('Manage Your Account: '.$username) ?></legend>
                                    <?php
                                    echo $this->Form->control('username');
                                    echo $this->Form->control('password');
                                    ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="control-group">
                        <h4>This Feature is included by the below Properties</h4>
                        <div style="padding-left:15px;">
                            <?php
                            foreach ($feature->properties as $p){
                                $unit = $p->house_number;
                                $country = $p->country;
                                $state = $p->state;
                                $suburb = $p->suburb;
                                $st = $p->street;
                                $postcode = $p->postcode;

                                $addr = $unit." ".$st.", ".$suburb.", ".$state.$postcode.", ".$country;
                                echo "<p class='fas fa-home inline_field'></p><p class='inline_field'>&nbsp;".$addr."</p><br>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save Feature',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes on this feature for all the properties?',
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


