<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Property $property
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Property'), ['action' => 'edit', $property->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Property'), ['action' => 'delete', $property->id], ['confirm' => __('Are you sure you want to delete # {0}?', $property->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Types'), ['controller' => 'Types', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type'), ['controller' => 'Types', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties Images'), ['controller' => 'PropertiesImages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Properties Image'), ['controller' => 'PropertiesImages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bookings'), ['controller' => 'Bookings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Booking'), ['controller' => 'Bookings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Features'), ['controller' => 'Features', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feature'), ['controller' => 'Features', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="properties view large-9 medium-8 columns content">
    <h3><?= h($property->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= h($property->country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= h($property->state) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Suburb') ?></th>
            <td><?= h($property->suburb) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Street') ?></th>
            <td><?= h($property->street) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('House Number') ?></th>
            <td><?= h($property->house_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $property->has('type') ? $this->Html->link($property->type->name, ['controller' => 'Types', 'action' => 'view', $property->type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('General Information') ?></th>
            <td><?= h($property->general_information) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($property->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Postcode') ?></th>
            <td><?= $this->Number->format($property->postcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Bedroom') ?></th>
            <td><?= $this->Number->format($property->number_of_bedroom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Bathroom') ?></th>
            <td><?= $this->Number->format($property->number_of_bathroom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Of Toilet') ?></th>
            <td><?= $this->Number->format($property->number_of_toilet) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Features') ?></h4>
        <?php if (!empty($property->features)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->features as $features): ?>
            <tr>
                <td><?= h($features->id) ?></td>
                <td><?= h($features->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Features', 'action' => 'view', $features->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Features', 'action' => 'edit', $features->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Features', 'action' => 'delete', $features->id], ['confirm' => __('Are you sure you want to delete # {0}?', $features->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($property->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Location') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->category_id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->location) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Properties Images') ?></h4>
        <?php if (!empty($property->properties_images)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Photo Name') ?></th>
                <th scope="col"><?= __('Photo Dir') ?></th>
                <th scope="col"><?= __('Property Id') ?></th>
                <th scope="col"><?= __('Room Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->properties_images as $propertiesImages): ?>
            <tr>
                <td><?= h($propertiesImages->id) ?></td>
                <td><?= h($propertiesImages->photo_name) ?></td>
                <td><?= h($propertiesImages->photo_dir) ?></td>
                <td><?= h($propertiesImages->property_id) ?></td>
                <td><?= h($propertiesImages->room_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PropertiesImages', 'action' => 'view', $propertiesImages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PropertiesImages', 'action' => 'edit', $propertiesImages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PropertiesImages', 'action' => 'delete', $propertiesImages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiesImages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Rooms') ?></h4>
        <?php if (!empty($property->rooms)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Property Id') ?></th>
                <th scope="col"><?= __('Room Type') ?></th>
                <th scope="col"><?= __('Room General Information') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->rooms as $rooms): ?>
            <tr>
                <td><?= h($rooms->id) ?></td>
                <td><?= h($rooms->property_id) ?></td>
                <td><?= h($rooms->room_type) ?></td>
                <td><?= h($rooms->room_general_information) ?></td>
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
    <div class="related">
        <h4><?= __('Related Applications') ?></h4>
        <?php if (!empty($property->applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Property Id') ?></th>
                <th scope="col"><?= __('Room Id') ?></th>
                <th scope="col"><?= __('Number Of People') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Preferred Name') ?></th>
                <th scope="col"><?= __('Gender') ?></th>
                <th scope="col"><?= __('Contact Number') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Australian Citizen') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Additional Comment') ?></th>
                <th scope="col"><?= __('Enquiry Date') ?></th>
                <th scope="col"><?= __('Application Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->applications as $applications): ?>
            <tr>
                <td><?= h($applications->id) ?></td>
                <td><?= h($applications->property_id) ?></td>
                <td><?= h($applications->room_id) ?></td>
                <td><?= h($applications->number_of_people) ?></td>
                <td><?= h($applications->first_name) ?></td>
                <td><?= h($applications->last_name) ?></td>
                <td><?= h($applications->preferred_name) ?></td>
                <td><?= h($applications->gender) ?></td>
                <td><?= h($applications->contact_number) ?></td>
                <td><?= h($applications->email) ?></td>
                <td><?= h($applications->australian_citizen) ?></td>
                <td><?= h($applications->start_date) ?></td>
                <td><?= h($applications->end_date) ?></td>
                <td><?= h($applications->additional_comment) ?></td>
                <td><?= h($applications->enquiry_date) ?></td>
                <td><?= h($applications->application_status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $applications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $applications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $applications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Bookings') ?></h4>
        <?php if (!empty($property->bookings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Property Id') ?></th>
                <th scope="col"><?= __('Room Id') ?></th>
                <th scope="col"><?= __('Check In Date') ?></th>
                <th scope="col"><?= __('Check Out Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($property->bookings as $bookings): ?>
            <tr>
                <td><?= h($bookings->id) ?></td>
                <td><?= h($bookings->property_id) ?></td>
                <td><?= h($bookings->room_id) ?></td>
                <td><?= h($bookings->check_in_date) ?></td>
                <td><?= h($bookings->check_out_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Bookings', 'action' => 'view', $bookings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Bookings', 'action' => 'edit', $bookings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Bookings', 'action' => 'delete', $bookings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
