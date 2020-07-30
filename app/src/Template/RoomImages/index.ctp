<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoomImage[]|\Cake\Collection\CollectionInterface $roomImages
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Room Image'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="roomImages index large-9 medium-8 columns content">
    <h3><?= __('Room Images') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('property_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('room_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo_dir') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roomImages as $roomImage): ?>
            <tr>
                <td><?= $this->Number->format($roomImage->id) ?></td>
                <td><?= $roomImage->has('property') ? $this->Html->link($roomImage->property->id, ['controller' => 'Properties', 'action' => 'view', $roomImage->property->id]) : '' ?></td>
                <td><?= $roomImage->has('room') ? $this->Html->link($roomImage->room->id, ['controller' => 'Rooms', 'action' => 'view', $roomImage->room->id]) : '' ?></td>
                <td><?= h($roomImage->photo_name) ?></td>
                <td><?= h($roomImage->photo_dir) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $roomImage->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roomImage->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $roomImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomImage->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
