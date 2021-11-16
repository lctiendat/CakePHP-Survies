<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Result Entity
 *
 * @property int $id
 * @property int $survey_id
 * @property int $answer_id
 * @property int $user_id
 * @property int $DELETE_FLG
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Survey $survey
 * @property \App\Model\Entity\Answer $answer
 * @property \App\Model\Entity\User $user
 */
class Result extends Entity
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
        'category_id' => true,
        'survey_id' => true,
        'answer_id' => true,
        'user_id' => true,
        'DELETE_FLG' => true,
        'created' => true,
        'modified' => true,
        'survey' => true,
        'answer' => true,
        'user' => true,
    ];
}
