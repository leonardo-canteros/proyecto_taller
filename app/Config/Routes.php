<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('principal', 'Home::index'); // "Home" con H mayúscula
$routes->get('quienes_somos', 'Home::quienes_somos'); // Nombre corregido
