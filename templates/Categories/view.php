<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categories view content">
            <h3><?= h($category->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($category->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Survies') ?></h4>
                <?php if (!empty($category->survies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Question') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Asw1') ?></th>
                            <th><?= __('Asw2') ?></th>
                            <th><?= __('Asw3') ?></th>
                            <th><?= __('Asw4') ?></th>
                            <th><?= __('Aswanother') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Type Select Id') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Time Start') ?></th>
                            <th><?= __('Time End') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($category->survies as $survies) : ?>
                        <tr>
                            <td><?= h($survies->id) ?></td>
                            <td><?= h($survies->question) ?></td>
                            <td><?= h($survies->description) ?></td>
                            <td><?= h($survies->asw1) ?></td>
                            <td><?= h($survies->asw2) ?></td>
                            <td><?= h($survies->asw3) ?></td>
                            <td><?= h($survies->asw4) ?></td>
                            <td><?= h($survies->aswanother) ?></td>
                            <td><?= h($survies->status) ?></td>
                            <td><?= h($survies->type_select_id) ?></td>
                            <td><?= h($survies->category_id) ?></td>
                            <td><?= h($survies->user_id) ?></td>
                            <td><?= h($survies->created_at) ?></td>
                            <td><?= h($survies->time_start) ?></td>
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
