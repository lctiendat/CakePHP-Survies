<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use PhpParser\Builder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    // $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    // Admin Manager Category
    $builder->connect('/admin/categories', 'Categories::index');
    $builder->connect('/admin/categories/add', 'Categories::add');
    $builder->connect('/admin/categories/edit/:id', 'Categories::edit', ['pass' => ['id']]);

    // Admin Manager Answer
    $builder->connect('/admin/answers', 'Answers::index');
    $builder->connect('/admin/answers/add', 'Answers::add');
    $builder->connect('/admin/answers/edit/:id', 'Answers::edit', ['pass' => ['id']]);
    // Admin Mannager User
    $builder->connect('/admin/users', 'Users::index');
    $builder->connect('/admin/users/edit/:id', 'Users::edit', ['pass' => ['id']]);

    // Admin Manager Survey
    $builder->connect('/admin/survies', 'Survies::index');
    $builder->connect('/admin/survies/add', 'Survies::add');
    $builder->connect('/admin/survies/edit/:id', 'Survies::edit', ['pass' => ['id']]);
    // Admin Manager Thống kê
    $builder->connect('/admin/statistical/category/:id', 'Statisticals::category', ['pass' => ['id']]);
    $builder->connect('/admin/statistical/survey/:id', 'Statisticals::survey', ['pass' => ['id']]);
    //index admin
    $builder->connect('/admin', 'Admin::index');

    //Auth
    $builder->connect('/Auth/register', 'Auths::register');
    $builder->connect('/Auth/login', 'Auths::login');
    $builder->connect('/Auth/logout', 'Auths::logout');
    $builder->connect('/Auth/change', 'Auths::changeinfor');
    $builder->connect('/Auth/changepass', 'Auths::changepassword');
    $builder->connect('/Auth/forget', 'Auths::forget');
    $builder->connect('/Auth/renew', 'Auths::renewPassword');
    $builder->connect('/Auth/testmail', 'Auths::testmail');

    //Home

    $builder->connect('/', 'Homes::index');
    $builder->connect('/category/:id', ['controller' => 'Homes', 'action' => 'getSurviesByCategory'], ['pass' => ['id']]);
    $builder->connect('/result/save/:id_survey', 'Homes::getDataSubmit', ['pass' => ['id_survey']]);
    $builder->connect('/category/:id_category/question/:id_question', ['controller' => 'Homes', 'action' => 'showQuestion'], ['pass' => ['id_category', 'id_question']]);
    $builder->connect('/result/saveNoLogin/:id_survey', 'Homes::getResultDontLogin', ['pass' => ['id_survey']]);
    $builder->connect('/img/avatar/*', 'Users::changeinfor');

    //Page error
    $builder->connect('/404page', 'Homes::page404');
    //
    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *     
 *     // Connect API actions here.
 * });
 * ```
 */
