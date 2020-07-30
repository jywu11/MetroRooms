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
    <title>Edit FAQ | Admin</title>
    <?php $this->assign("title","Edit Frequently Asked Question | NAIM Admin"); ?>
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
                ['controller' => 'Faqs', 'action' => 'view'],
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
                    'FAQ Content',
                    ['controller' => 'Faqs', 'action' => 'view'],
                    ['class' => '', 'confirm' => 'Are you Sure to leave this page?\nAll your unsaved changes will be lost.',]
                );
                ?>
            </li>
            <li>Edit Frequently Asked Question</li>
        </ul>
    </div>
    <div class="container">
        <!-- page content -->
        <div>
            <h1>Edit Frequently Asked Question</h1>
            <div class="inline_field">
                <?php
                echo $this->Form->postButton(
                    ' Delete',
                    ['controller' => 'Faqs', 'action' => 'delete', $faq->id],
                    ['confirm' => 'Are you sure to delete this FAQ?\nIt will be deleted forever from all the properties that are recording it.\nYou CANNOT undo the action',
                        'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                        'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                );
                ?>
            </div>
        </div>

        <?= $this->Form->create($faq, ['id' => 'myform']) ?>
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group">
                        <fieldset>
                            <div>
                                <?php
                                echo $this->Form->control('question', ['label' =>'Change FAQ Question', 'type' => 'textarea',
                                    'class' => 'span12', 'style'=> '',
                                    'data-validation' => 'length alphanumeric',
                                    'data-validation-length' => 'max500',
                                    'data-validation-allowing' => " ?():,.&;/=!",
                                    'data-validation-error-msg-alphanumeric' => 'FAQ Question should not include invalid character or be empty',
                                    'data-validation-error-msg' =>  'FAQ Question has exceeded 500 words limit'
                                ]);
                                ?>
                            </div>
                            <br>
                            <div>
                                <?php
                                echo $this->Form->control('answer', ['label' =>'Change FAQ Answer', 'type' => 'textarea',
                                    'class' => 'span12', 'style'=> '',
                                    'data-validation' => 'length alphanumeric',
                                    'data-validation-length' => 'max500',
                                    'data-validation-allowing' => " ?():,.&;/=!",
                                    'data-validation-error-msg-alphanumeric' => 'FAQ Answer should not include invalid character or be empty',
                                    'data-validation-error-msg' =>  'FAQ Question has exceeded 500 words limit'
                                ]);
                                ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Form->button('Save FAQ',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes on this FAQ?',
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
