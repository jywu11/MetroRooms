<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","Add Feature | NAIM Admin"); ?>
</head>
<!-- end of header -->


<style>

    .inline_field{
        display: inline-block;
    }

    body {
        background: rgba(131, 129, 128, 0.41);
    }

</style>


<body>
    <!-- top nav bar -->
    <?php echo $this->element('admin_topbar'); ?>
    <!-- end of top nav bar -->



    <!-- content -->
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="features form large-9 medium-8 columns content">
        <?= $this->Form->create($feature) ?>
        <fieldset>
            <legend><?= __('Add Feature') ?></legend>
            <?php
           echo $this->Form->control('name');
                echo $this->Form->control('properties._ids', ['options' => $properties]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- footer -->
    <?php echo $this->element('admin_footer'); ?>
    <!-- end of footer -->
</body>
