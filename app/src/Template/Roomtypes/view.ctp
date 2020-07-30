<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roomtype $roomtype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Roomtype'), ['action' => 'edit', $roomtype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Roomtype'), ['action' => 'delete', $roomtype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roomtype->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roomtypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Roomtype'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roomtypes view large-9 medium-8 columns content">
    <h3><?= h($roomtype->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($roomtype->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($roomtype->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Rooms') ?></h4>
        <?php if (!empty($roomtype->rooms)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Property Id') ?></th>
                <th scope="col"><?= __('Roomtype Id') ?></th>
                <th scope="col"><?= __('Room General Information') ?></th>
                <th scope="col"><?= __('Room Name') ?></th>
                <th scope="col"><?= __('Room Capacity') ?></th>
                <th scope="col"><?= __('Rental End Date') ?></th>
                <th scope="col"><?= __('Current Number Of People Staying') ?></th>
                <th scope="col"><?= __('Last Rental End Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($roomtype->rooms as $rooms): ?>
            <tr>
                <td><?= h($rooms->id) ?></td>
                <td><?= h($rooms->property_id) ?></td>
                <td><?= h($rooms->roomtype_id) ?></td>
                <td><?= h($rooms->room_general_information) ?></td>
                <td><?= h($rooms->room_name) ?></td>
                <td><?= h($rooms->room_capacity) ?></td>
                <td><?= h($rooms->rental_end_date) ?></td>
                <td><?= h($rooms->current_number_of_people_staying) ?></td>
                <td><?= h($rooms->last_rental_end_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Rooms', 'action' => 'view', $rooms->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Rooms', 'action' => 'edit', $rooms->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rooms', 'action' => 'delete', $rooms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rooms->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
