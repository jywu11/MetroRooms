<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Applicant $applicant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $applicant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $applicant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Applicants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="applicants form large-9 medium-8 columns content">
    <?= $this->Form->create($applicant) ?>
    <fieldset>
        <legend><?= __('Edit Applicant') ?></legend>
        <?php
            echo $this->Form->control('application_id', ['options' => $applications]);
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('preferred_name');
            echo $this->Form->control('gender');
            echo $this->Form->control('australian_citizen');
            echo $this->Form->control('contact_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
