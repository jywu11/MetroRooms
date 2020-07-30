<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Feature'), ['action' => 'edit', $feature->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Feature'), ['action' => 'delete', $feature->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feature->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Features'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feature'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="features view large-9 medium-8 columns content">
    <h3><?= h($feature->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($feature->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($feature->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Properties') ?></h4>
        <?php if (!empty($feature->properties)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Country') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Suburb') ?></th>
                <th scope="col"><?= __('Street') ?></th>
                <th scope="col"><?= __('Postcode') ?></th>
                <th scope="col"><?= __('House Number') ?></th>
                <th scope="col"><?= __('Number Of Bedroom') ?></th>
                <th scope="col"><?= __('Number Of Bathroom') ?></th>
                <th scope="col"><?= __('Type Id') ?></th>
                <th scope="col"><?= __('General Information') ?></th>
                <th scope="col"><?= __('Number Of Toilet') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($feature->properties as $properties): ?>
            <tr>
                <td><?= h($properties->id) ?></td>
                <td><?= h($properties->country) ?></td>
                <td><?= h($properties->state) ?></td>
                <td><?= h($properties->suburb) ?></td>
                <td><?= h($properties->street) ?></td>
                <td><?= h($properties->postcode) ?></td>
                <td><?= h($properties->house_number) ?></td>
                <td><?= h($properties->number_of_bedroom) ?></td>
                <td><?= h($properties->number_of_bathroom) ?></td>
                <td><?= h($properties->type_id) ?></td>
                <td><?= h($properties->general_information) ?></td>
                <td><?= h($properties->number_of_toilet) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Properties', 'action' => 'view', $properties->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Properties', 'action' => 'edit', $properties->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Properties', 'action' => 'delete', $properties->id], ['confirm' => __('Are you sure you want to delete # {0}?', $properties->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
