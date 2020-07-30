<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Frontcontent $frontcontent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Frontcontent'), ['action' => 'edit', $frontcontent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Frontcontent'), ['action' => 'delete', $frontcontent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $frontcontent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Frontcontents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Frontcontent'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="frontcontents view large-9 medium-8 columns content">
    <h3><?= h($frontcontent->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Top Foot Logo') ?></th>
            <td><?= h($frontcontent->top_foot_logo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banner Image') ?></th>
            <td><?= h($frontcontent->banner_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Banner Title') ?></th>
            <td><?= h($frontcontent->banner_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Title') ?></th>
            <td><?= h($frontcontent->home_service_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Desc') ?></th>
            <td><?= h($frontcontent->home_service_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Entry1') ?></th>
            <td><?= h($frontcontent->home_service_entry1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Entry2') ?></th>
            <td><?= h($frontcontent->home_service_entry2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Entry3') ?></th>
            <td><?= h($frontcontent->home_service_entry3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Home Service Entry4') ?></th>
            <td><?= h($frontcontent->home_service_entry4) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Foot Abt Desc') ?></th>
            <td><?= h($frontcontent->foot_abt_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Title') ?></th>
            <td><?= h($frontcontent->abt_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Desc') ?></th>
            <td><?= h($frontcontent->abt_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Title') ?></th>
            <td><?= h($frontcontent->abt_person_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Image') ?></th>
            <td><?= h($frontcontent->abt_person_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Name') ?></th>
            <td><?= h($frontcontent->abt_person_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Email') ?></th>
            <td><?= h($frontcontent->abt_person_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Desc') ?></th>
            <td><?= h($frontcontent->abt_person_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('House Question') ?></th>
            <td><?= h($frontcontent->house_question) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('House Answer') ?></th>
            <td><?= h($frontcontent->house_answer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($frontcontent->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Abt Person Phonr') ?></th>
            <td><?= $this->Number->format($frontcontent->abt_person_phonr) ?></td>
        </tr>
    </table>
</div>
