<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Survy $survy
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Survy'), ['action' => 'edit', $survy->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Survy'), ['action' => 'delete', $survy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $survy->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Survies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Survy'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="survies view content">
            <h3><?= h($survy->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Question') ?></th>
                    <td><?= h($survy->question) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($survy->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $survy->has('category') ? $this->Html->link($survy->category->name, ['controller' => 'Categories', 'action' => 'view', $survy->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $survy->has('user') ? $this->Html->link($survy->user->id, ['controller' => 'Users', 'action' => 'view', $survy->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($survy->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($survy->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($survy->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($survy->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time End') ?></th>
                    <td><?= h($survy->time_end) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
