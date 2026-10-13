<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Portal Ana Sayfası
     */
    public function index(): string
    {
        return view('home');
    }

    /**
     * Çift Sayfalı Kitap Okuyucu
     */
    public function kitapOku(): string
    {
        return view('kitap_oku');
    }

    /**
     * Kitaplar Listesi & Arşiv
     */
    public function kitaplar(): string
    {
        return view('kitaplar');
    }

    /**
     * Online Deneme Sınavları
     */
    public function denemeSinavlari(): string
    {
        return view('deneme_sinavlari');
    }

    /**
     * Sınav Odak Ekranı
     */
    public function sinavEkrani(): string
    {
        return view('sinav_ekrani');
    }

    /**
     * Öğrenci/Yarışmacı Karnesi & İstatistikler
     */
    public function dashboard(): string
    {
        return view('dashboard');
    }

    /**
     * Başarı Sıralamaları & Kürsü
     */
    public function siralamalar(): string
    {
        return view('siralamalar');
    }

    /**
     * Kurumsal Bilgi & Şartname Sayfası
     */
    public function sayfa(): string
    {
        return view('sayfa');
    }
}
