<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Herkese Açık Sayfalar
$routes->get('/', 'Home::index');
$routes->get('kitaplar', 'Home::kitaplar');
$routes->get('siralamalar', 'Home::siralamalar');

// Kurumsal & İçerik Sayfaları (Ufka Yolculuk API Destekli)
$routes->get('sayfa', 'Home::sayfa');
$routes->get('sayfa/(:segment)', 'Home::sayfa/$1');
$routes->get('hakkimizda', 'Home::sayfa/hakkimizda');
$routes->get('sartname', 'Home::sayfa/sartname');
$routes->get('yonerge', 'Home::sayfa/yonerge');
$routes->get('sss', 'Home::sayfa/sss');
$routes->get('kvkk', 'Home::sayfa/uy-kvkk-aydinlatma-metni');

// Oturum Gerektiren Korumalı Sayfalar (Cross-Subdomain AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('kitap-oku', 'Home::kitapOku');
    $routes->get('sinav-ekrani', 'Home::sinavEkrani');
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('deneme-sinavlari', 'Home::denemeSinavlari');
});

// Oturum Test & Simülasyon Rotaları (Localhost geliştirme için)
$routes->get('auth/me', 'Api\ApiController::me');
$routes->get('auth/simulate-login', 'Api\ApiController::simulateLogin');
$routes->get('auth/logout', 'Api\ApiController::logout');

// API V1 Rotaları
$routes->group('api/v1', static function ($routes) {
    $routes->get('health', 'Api\ApiController::health');
    $routes->get('books', 'Api\ApiController::books');
    $routes->get('books/(:num)', 'Api\ApiController::bookDetail/$1');
    $routes->get('books/(:num)/pages', 'Api\ApiController::bookPages/$1');
    $routes->get('books/(:num)/audio-sync', 'Api\ApiController::audioSync/$1');
    $routes->get('exams', 'Api\ApiController::exams');

    // Sayfalar & İçerikler REST API
    $routes->get('pages', 'Api\ApiController::pages');
    $routes->get('pages/(:segment)', 'Api\ApiController::pageDetail/$1');
    $routes->get('faqs', 'Api\ApiController::faqs');

    // Oturum Korumalı API Rotaları
    $routes->group('', ['filter' => 'auth'], static function ($routes) {
        $routes->get('user/profile', 'Api\ApiController::me');
        $routes->post('progress/sync', 'Api\ApiController::saveProgress');
    });
});
