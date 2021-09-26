<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($user->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($user->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($user->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $this->Number->format($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Survies') ?></h4>
                <?php if (!empty($user->survies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Question') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Time End') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->survies as $survies) : ?>
                        <tr>
                            <td><?= h($survies->id) ?></td>
                            <td><?= h($survies->question) ?></td>
                            <td><?= h($survies->description) ?></td>
                            <td><?= h($survies->status) ?></td>
                            <td><?= h($survies->category_id) ?></td>
                            <td><?= h($survies->user_id) ?></td>
                            <td><?= h($survies->created) ?></td>
                            <td><?= h($survies->modified) ?></td>
                            <td><?= h($survies->time_end) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Survies', 'action' => 'view', $survies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Survies', 'action' => 'edit', $survies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Survies', 'action' => 'delete', $survies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $survies->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
