<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertiesFeature $propertiesFeature
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Properties Features'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Features'), ['controller' => 'Features', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feature'), ['controller' => 'Features', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="propertiesFeatures form large-9 medium-8 columns content">
    <?= $this->Form->create($propertiesFeature) ?>
    <fieldset>
        <legend><?= __('Add Properties Feature') ?></legend>
        <?php
            echo $this->Form->control('property_id', ['options' => $properties]);
            echo $this->Form->control('feature_id', ['options' => $features]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
