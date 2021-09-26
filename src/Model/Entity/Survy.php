<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Survy Entity
 *
 * @property int $id
 * @property string $question
 * @property string $description
 * @property int $status
 * @property int $category_id
 * @property int $user_id
 * @property int $type_select
 * @property int $DELETE_FLG
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime|null $time_end
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\User $user
 */
class Survy extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'question' => true,
        'description' => true,
        'status' => true,
        'category_id' => true,
        'user_id' => true,
        'type_select' => true,
        'DELETE_FLG' => true,
        'created' => true,
        'modified' => true,
        'time_end' => true,
        'category' => true,
        'user' => true,
    ];
}
