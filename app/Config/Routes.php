<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Herkese Açık Sayfalar
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home.html', 'Home::index');
$routes->get('index.html', 'Home::index');
$routes->get('kitaplar', 'Home::kitaplar');
$routes->get('kitaplar.html', 'Home::kitaplar');
$routes->get('siralamalar', 'Home::siralamalar');
$routes->get('siralamalar.html', 'Home::siralamalar');

// Kurumsal & İçerik Sayfaları (Ufka Yolculuk API Destekli)
$routes->get('sayfa', 'Home::sayfa');
$routes->get('sayfa/(:segment)', 'Home::sayfa/$1');
$routes->get('hakkimizda', 'Home::sayfa/hakkimizda');
$routes->get('sartname', 'Home::sayfa/sartname');
$routes->get('yonerge', 'Home::sayfa/yonerge');
$routes->get('sss', 'Home::sayfa/sss');
$routes->get('kvkk', 'Home::sayfa/uy-kvkk-aydinlatma-metni');

// Kitap Okuma Sayfaları (Herkese Açık - kitap-oku, kitapoku, kitap_oku ve .html varyasyonları)
$routes->get('kitap-oku', 'Home::kitapOku');
$routes->get('kitap-oku.html', 'Home::kitapOku');
$routes->get('kitapoku', 'Home::kitapOku');
$routes->get('kitapoku.html', 'Home::kitapOku');
$routes->get('kitap_oku', 'Home::kitapOku');
$routes->get('kitap_oku.html', 'Home::kitapOku');

// Oturum Gerektiren Korumalı Sayfalar (Cross-Subdomain AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('sinav-ekrani', 'Home::sinavEkrani');
    $routes->get('sinav-ekrani.html', 'Home::sinavEkrani');
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('dashboard.html', 'Home::dashboard');
    $routes->get('deneme-sinavlari', 'Home::denemeSinavlari');
    $routes->get('deneme-sinavlari.html', 'Home::denemeSinavlari');
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
    $routes->get('books/(:num)/page-text/(:num)', 'Api\ApiController::pageText/$1/$2');
    $routes->get('books/(:num)/audio-sync', 'Api\ApiController::audioSync/$1');
    $routes->get('exams', 'Api\ApiController::exams');
    $routes->get('exams/(:num)', 'Api\ApiController::examDetail/$1');
    $routes->post('exams/(:num)/submit', 'Api\ApiController::submitExam/$1');
    $routes->get('leaderboard', 'Api\ApiController::leaderboard');
    $routes->get('stats', 'Api\ApiController::stats');
    $routes->get('progress/(:num)/(:num)', 'Api\ApiController::getProgress/$1/$2');

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
