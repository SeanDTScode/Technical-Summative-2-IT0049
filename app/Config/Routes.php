<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setAutoRoute(false);

// Public pages
$routes->get('/', 'Welcome::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('profile', 'Profile::index');
$routes->get('about', 'Pages::about');
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::login');

// Protected task-management actions
$routes->get('tasks/new', 'Tasks::new', ['filter' => 'auth']);
$routes->post('tasks', 'Tasks::create', ['filter' => 'auth']);
$routes->get('tasks/(:num)/edit', 'Tasks::edit/$1', ['filter' => 'auth']);
$routes->post('tasks/(:num)', 'Tasks::update/$1', ['filter' => 'auth']);
$routes->post('tasks/(:num)/archive', 'Tasks::archive/$1', ['filter' => 'auth']);
$routes->post('logout', 'Auth::logout', ['filter' => 'auth']);

