<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Frontcontent $frontcontent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Frontcontents'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="frontcontents form large-9 medium-8 columns content">
    <?= $this->Form->create($frontcontent) ?>
    <fieldset>
        <legend><?= __('Add Frontcontent') ?></legend>
        <?php
            echo $this->Form->control('top_foot_logo');
            echo $this->Form->control('banner_image');
            echo $this->Form->control('banner_title');
            echo $this->Form->control('home_service_title');
            echo $this->Form->control('home_service_desc');
            echo $this->Form->control('home_service_entry1');
            echo $this->Form->control('home_service_entry2');
            echo $this->Form->control('home_service_entry3');
            echo $this->Form->control('home_service_entry4');
            echo $this->Form->control('foot_abt_desc');
            echo $this->Form->control('abt_title');
            echo $this->Form->control('abt_desc');
            echo $this->Form->control('abt_person_title');
            echo $this->Form->control('abt_person_image');
            echo $this->Form->control('abt_person_name');
            echo $this->Form->control('abt_person_email');
            echo $this->Form->control('abt_person_phonr');
            echo $this->Form->control('abt_person_desc');
            echo $this->Form->control('house_question');
            echo $this->Form->control('house_answer');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
