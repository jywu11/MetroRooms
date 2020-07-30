<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","View Application | NAIM Admin"); ?>
</head>
<!-- end of head -->

<div class="applications form large-9 medium-8 columns content">
    <?= $this->Form->create($application) ?>
    <fieldset>
        <legend><?= __('Edit Application') ?></legend>
        <?php
        echo $this->Form->control('property_id', ['options' => $properties]);
        echo $this->Form->control('room_id', ['options' => $rooms]);
        echo $this->Form->control('number_of_people');
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('preferred_name');
        echo $this->Form->control('gender');
        echo $this->Form->control('contact_number');
        echo $this->Form->control('email');
        echo $this->Form->control('australian_citizen');
        echo $this->Form->control('start_date');
        echo $this->Form->control('end_date');
        echo $this->Form->control('additional_comment');
        echo $this->Form->control('enquiry_date');
        echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>


<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
