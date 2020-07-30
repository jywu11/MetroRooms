<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertyImage $propertyImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Property Image'), ['action' => 'edit', $propertyImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Property Image'), ['action' => 'delete', $propertyImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertyImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Property Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="propertyImages view large-9 medium-8 columns content">
    <h3><?= h($propertyImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Photo Name') ?></th>
            <td><?= h($propertyImage->photo_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo Dir') ?></th>
            <td><?= h($propertyImage->photo_dir) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Property') ?></th>
            <td><?= $propertyImage->has('property') ? $this->Html->link($propertyImage->property->id, ['controller' => 'Properties', 'action' => 'view', $propertyImage->property->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($propertyImage->id) ?></td>
        </tr>
    </table>
</div>
