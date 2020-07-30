<?php
/**
 * @var \App\View\AppView $this
 * @var $users
 */
?>

<!-- head of the page -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","NAIM Admin | Login"); ?>
    <?php echo $this->Html->css('/bootstrap/css/bootstrap.min.css');?>
    <?php echo $this->Html->css('/bootstrap/css/bootstrap-responsive.min.css');?>
    <?php echo $this->Html->css('/css/theme.css');?>
    <?php echo $this->Html->css('/images/icons/css/font-awesome.css');?>
    <?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600');?>
</head>
<!-- end of header -->
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <i class="icon-reorder shaded"></i>
            </a>

            <a class="brand">
                NAIM
            </a>

            <div class="nav-collapse collapse navbar-inverse-collapse">

            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->



<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="module module-login span4 offset4">
                <form class="form-vertical">
                    <div class="module-head">
                        <h3>Sign In</h3>
                    </div>
                    <div class="module-body">
                        <div class="control-group">
                            <div class="controls row-fluid">
                                <?= $this->Form->create() ?>
                                <?php echo $this->Form->control('username', ['class' => 'span12','required']); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls row-fluid">
                                <?php echo $this->Form->control('password', ['class' => 'span12','required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="module-foot">
                        <div class="control-group">
                            <div class="controls clearfix">
                                <?php echo $this->Form->button('Login', ['class' => 'btn btn-primary pull-right']); ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--/.wrapper-->


</div>
<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

<!-- end of page content -->

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
