<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertyImage $propertyImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Property Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="propertyImages form large-9 medium-8 columns content">
    <?= $this->Form->create($propertyImage) ?>
    <fieldset>
        <legend><?= __('Add Property Image') ?></legend>
        <?php
            echo $this->Form->control('photo_name');
            echo $this->Form->control('photo_dir');
            echo $this->Form->control('property_id', ['options' => $properties, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
