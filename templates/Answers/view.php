<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Answer $answer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Answer'), ['action' => 'edit', $answer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Answer'), ['action' => 'delete', $answer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $answer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Answers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Answer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="answers view content">
            <h3><?= h($answer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($answer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($answer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Survey Id') ?></th>
                    <td><?= $this->Number->format($answer->survey_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('DELETE FLG') ?></th>
                    <td><?= $this->Number->format($answer->DELETE_FLG) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($answer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($answer->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Results') ?></h4>
                <?php if (!empty($answer->results)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Survey Id') ?></th>
                            <th><?= __('Answer Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('DELETE FLG') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($answer->results as $results) : ?>
                        <tr>
                            <td><?= h($results->id) ?></td>
                            <td><?= h($results->survey_id) ?></td>
                            <td><?= h($results->answer_id) ?></td>
                            <td><?= h($results->user_id) ?></td>
                            <td><?= h($results->DELETE_FLG) ?></td>
                            <td><?= h($results->created) ?></td>
                            <td><?= h($results->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Results', 'action' => 'view', $results->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Results', 'action' => 'edit', $results->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Results', 'action' => 'delete', $results->id], ['confirm' => __('Are you sure you want to delete # {0}?', $results->id)]) ?>
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
