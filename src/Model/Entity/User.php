<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $avatar
 * @property string $password
 * @property string|null $address
 * @property int $status
 * @property int $role
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Result[] $results
 * @property \App\Model\Entity\Survy[] $survies
 */
class User extends Entity
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
        'email' => true,
        'phone' => true,
        'avatar' => true,
        'password' => true,
        'address' => true,
        'token' => true,
        'status' => true,
        'role' => true,
        'created' => true,
        'modified' => true,
        'results' => true,
        'survies' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
