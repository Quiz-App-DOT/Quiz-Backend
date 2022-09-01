<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Quiz App (Queez)

Aplikasi kuis menggunakan backend laravel dan frontend react. Aplikasi dibangun dengan menggunakan model service. Aplikasi dapat menampung data user serta kuis yang pernah diikuti oleh user.

## Depedency

Depedencies yang digunakan untuk Backend
- [Guzzle](https://docs.guzzlephp.org/en/stable/)
- [JWT](https://github.com/tymondesigns/jwt-auth)

## Config & Running

Hal yang perlu disetup di awal:
- jalankan command composser install dahulu
- tambahkan cors dan force.jsonresponse pada http/app/kernel
- tambahkan cors dan json response ke dalam middleware
- ubah config auth menjadi jwt untuk bagian api
- buat database (pgsql atau mysql) pada kasus ini saya menggunakan pgsql. Kemudian setup database ke dalam .env
- buat variable env yaitu JWT_SECRET dengan value bebas

Cara menjalankan code:
- gunakan command php artisan migrate:refresh --seed dahulu untuk melakukan inisiasi database
- gunakan command php artisan serv untuk menjalankan code

## Deployment

Deploy backend terletak pada link https://quiz-dot-backend.herokuapp.com

Deploy frontend terletak pada link https://dot-quiz.netlify.app
dengan CI/CD ke github https://github.com/Quiz-App-DOT/Quiz-Frontend