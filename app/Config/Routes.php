<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Web Sayfa Rotaları
$routes->get('/', 'Home::index');
$routes->get('kitap-oku', 'Home::kitapOku');
$routes->get('kitaplar', 'Home::kitaplar');
$routes->get('deneme-sinavlari', 'Home::denemeSinavlari');
$routes->get('sinav-ekrani', 'Home::sinavEkrani');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('siralamalar', 'Home::siralamalar');
$routes->get('sayfa', 'Home::sayfa');

// API V1 Rotaları (REST API Hazırlığı)
$routes->group('api/v1', static function ($routes) {
    $routes->get('health', 'Api\ApiController::health');
    $routes->get('books', 'Api\ApiController::books');
    $routes->get('books/(:num)', 'Api\ApiController::bookDetail/$1');
    $routes->get('books/(:num)/pages', 'Api\ApiController::bookPages/$1');
    $routes->get('books/(:num)/audio-sync', 'Api\ApiController::audioSync/$1');
    $routes->post('progress/sync', 'Api\ApiController::saveProgress');
    $routes->get('exams', 'Api\ApiController::exams');
});
