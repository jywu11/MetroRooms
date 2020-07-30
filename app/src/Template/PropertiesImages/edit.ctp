<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertiesImage $propertiesImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $propertiesImage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $propertiesImage->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Properties Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="propertiesImages form large-9 medium-8 columns content">
    <?= $this->Form->create($propertiesImage) ?>
    <fieldset>
        <legend><?= __('Edit Properties Image') ?></legend>
        <?php
            echo $this->Form->control('photo_name');
            echo $this->Form->control('photo_dir');
            echo $this->Form->control('property_id', ['options' => $properties, 'empty' => true]);
            echo $this->Form->control('room_id', ['options' => $rooms, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
