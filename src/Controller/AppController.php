<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Category');
        $this->loadComponent('Home');
        $this->loadComponent('Answer');
        $this->loadComponent('Auth');
        $this->loadComponent('Statistical');
        $this->loadComponent('Survey');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    /**
     * Decentralization method
     */
    public function isAdmin()
    {
        $session = $this->request->getSession();
        if ($session->check('arrUserSession')) {
            $arrUserSession = $session->read('arrUserSession');
            $email = $arrUserSession['email'];
            $check_role = $this->{'Auth'}->queryUserByEmail($email);
            $role = '';
            foreach ($check_role as $item) {
                $role = $item->role;
            }
            if ($role != 9) {
                $this->Flash->error(__(IS_NOT_ADMIN));
                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__(DO_NOT_LOGIN));
            return $this->redirect(URL_AUTH_LOGIN);
        }
    }
}
