<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sipariş ve İndirim Rest Servis Projesi

### Kurulum
Projeyi indirdikten sonra , projenin ana klsorüne "restfull_api_orders_discount-main" terminal ile açınız. Docker compose ile aşağıdaki komutu calıştırınız.
- docker compose up -d

docker container webserver2 olan container içine giriniz ve terminal ile açınız.
example dizini içinde aşağıdaki sıra ile komutları çalıştırınız.

Aşağıdaki kod ile laravel kütüphanlerini indiriniz.
- composer install

Laravel key oluşturmak için aşağıdaki komutu çalıştırınız.
- php artisan key:generate

Proje tabloları:database/migrations klasörünün altındadır. tabloları veritabanına eklemek için aşağıdaki komutu çalıştırınız.
- php artisan migrate

Proje örnek veriler:database/seeders klasörünün altındadır. örnek verileri tabloya aktarmak için aşağıdaki komutu çalıştırınız.
- php artisan db:seed

kurulum bitmiştir.

### Endpoint
- postman_collection.json dosyasında, methodlar bulunmaktadır, istek atarak çalıştırabilirsiniz.
