<?php
/**
 * @var \App\View\AppView $this
 * @var $properties
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
    <?php $this->assign("title","NAIM Admin | Content Management"); ?>
</head>
<!-- end of header -->


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<div class="inline_field">
    <br><br>
    <h2>Content Management</h2>
</div>


<div class ="wrapper">
    <div class ="container">
        <div class="tab-wrap">
            <input type="radio" id="tab1" name="tabGroup1" class="tab" onclick="window.location='index';" >
            <label for="tab1">Feature Content</label>

            <input type="radio" id="tab2" name="tabGroup1" class="tab" onclick="window.location='item';">
            <label for="tab2">Item Content</label>

            <input type="radio" id="tab3" name="tabGroup1" class="tab" onclick="window.location='faq';">
            <label for="tab3">FAQ Content</label>

            <input type="radio" id="tab4" name="tabGroup1" class="tab" checked>
            <label for="tab4">Frontend Content</label>

            <!--Features Management-->
            <div class="tab__content">
                <!--Empty Content -->
            </div>

            <!--Item Management-->
            <div class="tab__content">
                <!--Empty Content -->
            </div>

            <!--FAQ Management-->
            <div class="tab__content">
                <!--Empty Content -->
            </div>

            <!--Homepage Management-->
            <div class="tab__content">
                <div class="inline_field">
                    <h1>Homepage Management</h1>
                </div><br>
            </div>

        </div>


    </div>
</div>












<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->














