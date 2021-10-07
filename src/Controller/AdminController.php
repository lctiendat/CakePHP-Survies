<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class AdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Auth');
        $this->loadComponent('Home');
    }

    // thống kê admin
    public function index()
    {
        $this->isAdmin();
        $category = $this->{'Home'}->countQualityCategory();
        $survey = $this->{'Home'}->countQualitySurvey();
        $answer = $this->{'Home'}->countQualityAnswer();
        $user = $this->{'Home'}->countQualityUser();
        $this->set(compact(['category', 'survey', 'answer', 'user']));
    }

    // phân quyền admin và user
    public function isAdmin()
    {
        $session = $this->request->getSession();
        if ($session->check('role')) {
            $email = $session->read('email');
            $check_role = $this->{'Auth'}->queryUserByEmail($email);
            $role = '';
            foreach ($check_role as $item) {
                $role = $item->role;
            }
            if ($role != 2) {
                $this->Flash->error(__('Bạn không phải Quản trị viên, bạn không có quyền truy cập'));
                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__('Bạn chưa đăng nhập'));
            return $this->redirect('/Auth/login');
        }
    }
}
