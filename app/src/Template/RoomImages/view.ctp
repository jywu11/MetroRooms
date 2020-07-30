<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoomImage $roomImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Room Image'), ['action' => 'edit', $roomImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Room Image'), ['action' => 'delete', $roomImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Room Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roomImages view large-9 medium-8 columns content">
    <h3><?= h($roomImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Property') ?></th>
            <td><?= $roomImage->has('property') ? $this->Html->link($roomImage->property->id, ['controller' => 'Properties', 'action' => 'view', $roomImage->property->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room') ?></th>
            <td><?= $roomImage->has('room') ? $this->Html->link($roomImage->room->id, ['controller' => 'Rooms', 'action' => 'view', $roomImage->room->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo Name') ?></th>
            <td><?= h($roomImage->photo_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo Dir') ?></th>
            <td><?= h($roomImage->photo_dir) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roomImage->id) ?></td>
        </tr>
    </table>
</div>
