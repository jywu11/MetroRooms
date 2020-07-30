<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Applicant $applicant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Applicant'), ['action' => 'edit', $applicant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Applicant'), ['action' => 'delete', $applicant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applicant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Applicants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applicant'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="applicants view large-9 medium-8 columns content">
    <h3><?= h($applicant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Application') ?></th>
            <td><?= $applicant->has('application') ? $this->Html->link($applicant->application->id, ['controller' => 'Applications', 'action' => 'view', $applicant->application->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($applicant->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($applicant->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Preferred Name') ?></th>
            <td><?= h($applicant->preferred_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gender') ?></th>
            <td><?= h($applicant->gender) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Australian Citizen') ?></th>
            <td><?= h($applicant->australian_citizen) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($applicant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contact Number') ?></th>
            <td><?= $this->Number->format($applicant->contact_number) ?></td>
        </tr>
    </table>
</div>
