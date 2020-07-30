<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PropertiesFeature[]|\Cake\Collection\CollectionInterface $propertiesFeatures
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Properties Feature'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Features'), ['controller' => 'Features', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feature'), ['controller' => 'Features', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="propertiesFeatures index large-9 medium-8 columns content">
    <h3><?= __('Properties Features') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('property_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('feature_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propertiesFeatures as $propertiesFeature): ?>
            <tr>
                <td><?= $this->Number->format($propertiesFeature->id) ?></td>
                <td><?= $propertiesFeature->has('property') ? $this->Html->link($propertiesFeature->property->id, ['controller' => 'Properties', 'action' => 'view', $propertiesFeature->property->id]) : '' ?></td>
                <td><?= $propertiesFeature->has('feature') ? $this->Html->link($propertiesFeature->feature->name, ['controller' => 'Features', 'action' => 'view', $propertiesFeature->feature->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $propertiesFeature->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $propertiesFeature->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $propertiesFeature->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiesFeature->id)]) ?>
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
