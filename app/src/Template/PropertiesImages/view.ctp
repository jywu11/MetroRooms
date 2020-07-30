<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertiesImage $propertiesImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Properties Image'), ['action' => 'edit', $propertiesImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Properties Image'), ['action' => 'delete', $propertiesImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiesImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Properties Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Properties Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="propertiesImages view large-9 medium-8 columns content">
    <h3><?= h($propertiesImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Photo Name') ?></th>
            <td><?= h($propertiesImage->photo_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo Dir') ?></th>
            <td><?= h($propertiesImage->photo_dir) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Property') ?></th>
            <td><?= $propertiesImage->has('property') ? $this->Html->link($propertiesImage->property->id, ['controller' => 'Properties', 'action' => 'view', $propertiesImage->property->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room') ?></th>
            <td><?= $propertiesImage->has('room') ? $this->Html->link($propertiesImage->room->id, ['controller' => 'Rooms', 'action' => 'view', $propertiesImage->room->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($propertiesImage->id) ?></td>
        </tr>
    </table>
</div>
