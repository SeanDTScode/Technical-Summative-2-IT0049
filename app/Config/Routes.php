<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public pages
$routes->get('/', 'Pages::home');
$routes->get('about', 'Pages::about');

// Authentication pages
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::login');
$routes->post('logout', 'Auth::logout');

// Protected account-management pages
$routes->group(
    '',
    ['filter' => 'auth'],
    static function (RouteCollection $routes): void {
        // Customer routes
        $routes->get(
            'customers',
            'Customers::index'
        );

        $routes->get(
            'customers/new',
            'Customers::new'
        );

        $routes->post(
            'customers/create',
            'Customers::create'
        );

        $routes->get(
            'customers/(:num)/edit',
            'Customers::edit/$1'
        );

        $routes->post(
            'customers/(:num)/update',
            'Customers::update/$1'
        );

        // User routes
        $routes->get(
            'users',
            'Users::index'
        );

        $routes->get(
            'users/new',
            'Users::new'
        );

        $routes->post(
            'users/create',
            'Users::create'
        );

        $routes->get(
            'users/(:num)/edit',
            'Users::edit/$1'
        );

        $routes->post(
            'users/(:num)/update',
            'Users::update/$1'
        );
    }
);