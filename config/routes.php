<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

/** Routes about client*/
$routes->scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', 'Homes::index');
    $routes->connect('/category/:id', 'Homes::getSurviesByCategory', ['pass' => ['id']]);
    $routes->connect('/result/save/:id_survey', 'Homes::getDataSubmit', ['pass' => ['id_survey']]);
    $routes->connect('/category/:id_category/question/:id_question', 'Homes::showQuestion', ['pass' => ['id_category', 'id_question']]);
    $routes->connect('/result/saveNoLogin/:id_survey', 'Homes::getResultDontLogin', ['pass' => ['id_survey']]);
    $routes->connect('/404page', 'Homes::page404');
    $routes->connect('/:id/question', 'Homes::showSurveyByCategory', ['pass' => ['id']]);
    $routes->connect('/savevoted/:id/login', 'Homes::saveVotedLogin', ['pass' => ['id']]);
    $routes->connect('/savevoted/:id/notlogin', 'Homes::saveVotedNotLogin', ['pass' => ['id']]);
    $routes->fallbacks();
});

/** Routes about admin*/
Router::prefix('Admin', function (RouteBuilder $routes) {

    /** Routes about admin home*/
    $routes->connect('/', 'Admin::index');

    /** Routes about 404page in admin*/
    $routes->connect('/404page', 'Admin::pageNotFound');

    /** Routes about category in admin*/
    $routes->scope('/categories', function (RouteBuilder $routes) {
        $routes->connect('/', 'Categories::index');
        $routes->connect('/add', 'Categories::add');
        $routes->connect('/edit:id', 'Categories::edit', ['pass' => ['id']]);
    });

    /** Routes about survey in admin*/
    $routes->scope('/survies', function (RouteBuilder $routes) {
        $routes->connect('/', 'Survies::index');
        $routes->connect('/add', 'Survies::add');
        $routes->connect('/edit:id', 'Survies::edit', ['pass' => ['id']]);
        $routes->connect('/:id/add', 'Survies::addAnswer', ['pass' => ['id']]);
        $routes->connect('/:survey_id/delete/:answer_id', 'Answers::delete', ['pass' => ['survey_id', 'answer_id']]);
    });

    /** Routes about user in admin*/
    $routes->scope('/users', function (RouteBuilder $routes) {
        $routes->connect('/', 'Users::index');
        $routes->connect('/add', 'Users::add');
        $routes->connect('/edit:id', 'Users::edit', ['pass' => ['id']]);
    });

    /** Routes about statis in admin*/
    $routes->scope('/statistical', function (RouteBuilder $routes) {
        $routes->connect('/survey/:id', 'Statisticals::survey', ['pass' => ['id']]);
    });
    $routes->fallbacks(DashedRoute::class);
});

/** Routes about auth*/
Router::prefix('/', function (RouteBuilder $routes) {
    $routes->scope('/auths', function (RouteBuilder $routes) {
        $routes->connect('/login', 'auths::login');
        $routes->connect('/logout', 'auths::logout');
        $routes->connect('/changeinfor', 'auths::changeinfor');
        $routes->connect('/changepass', 'auths::changepass');
        $routes->connect('/forget', 'auths::forget');
        $routes->connect('/register', 'auths::register');
        $routes->connect('/history', 'auths::history');
    });
    $routes->fallbacks(DashedRoute::class);
});
