<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>

<?php
$username = $this->getRequest()->getSession()->read('Auth.User.username');
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit My Account | Admin</title>
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
                $this->request->referer(),
                ['confirm' => 'Are you sure to go back?\nThe changes you made will not be saved',
                    'class' => 'button btn-large btn-inverse']
            );
            // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
            ?>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
                <div>
                    <h1><?= __('Manage Your Account: '.$username) ?></h1>
                </div>
                <?= $this->Form->create($user, ['id' => 'myform']) ?>
                <div class="module">
                    <div class="module-head">
                        <h3>Change your username or password below. If you decide not to change anything, press the back button above.</h3>

                    </div>
                    <div class="module-body">
                        <div class="form-horizontal row-fluid">

                            <div class="control-group">
                                <fieldset>
                                    <div>


                                        <?= $this->Form->create($user) ?>
                                        <fieldset>
                                            <?php
                                            echo $this->Form->control('username',['type' => 'text',
                                                'class' => 'span4', 'style'=> 'height:40px;', 'data-validation'=>'custom',
                                                'data-validation-regexp' => "^([A-Za-z ]+)$",
                                                'data-validation-error-msg'=> "Please enter a valid username."
                                            ]);
                                            echo "<br>";
                                            echo $this->Form->control('password',['type' => 'password','value'=>'',
                                                'class' => 'span4', 'style'=> 'height:40px;', 'data-validation'=>'strength',
                                                'data-validation-strength' => "2",
                                                'data-validation-error-msg'=> "<b><u> <span style='color:rgb(185,74,72)'>Your password is not strong enough, please follow these rules:</b></u></span></br> 1) Minimum 8 characters in your password. </br> 2) Include numbers, symbols, lower and upper case letters. </br> 3) Does not include dictionary words. (eg.houses or rental)"
                                            ]);
                                            echo "<br>";
                                            echo $this->Form->control('confirm_password',['type'=>'password','class' => 'span4', 'style'=> 'height:40px;']);
                                            ?>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="control-group">
                                <div style="padding-left:15px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->button('Save Details',
                    ['type' => 'submit',
                        'class' => 'button btn-success span11',
                        'style' => 'border-radius: 8px;',
                        'confirm' => 'Are you sure you want to save your changes for this account?',
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
    $.validate({
        modules : 'security'
    });
</script>
