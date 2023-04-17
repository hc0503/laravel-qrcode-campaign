# ✨QRMan✨

Dynamic QR code, logo QR code generate, tracking QR code scan, hitmap dashboard and admin panel using [Laravel 7](https://laravel.com) framework, [Vuexy](https://themeforest.net/item/vuexy-vuejs-html-laravel-admin-dashboard-template/23328599) template, [endroid/qr-code](https://github.com/endroid/qr-code) library

This is a fork of https://github.com/devdreamsolution/laravel7-qrcode-campaign. We re trying to fix some problems with the webapp, add docker and fix the documentation since it can be a really useful tool internally and for the community,


## Screenshots
![ScreenShot](/screenshots/screenshot1.png)
![ScreenShot](/screenshots/screenshot2.png)
![ScreenShot](/screenshots/screenshot3.png)
![ScreenShot](/screenshots/screenshot4.png)
![ScreenShot](/screenshots/screenshot5.png)
![ScreenShot](/screenshots/screenshot6.png)
![ScreenShot](/screenshots/screenshot7.png)
![ScreenShot](/screenshots/screenshot8.png)
![ScreenShot](/screenshots/screenshot9.png)

## Installation

#### Composer install
```sh
sudo composer self-update --2
composer install
composer require predis/predis
```

#### Laravel key generate
Only when you start the project the first time, run

```sh
php artisan key:generate
```

#### Node module install
```sh
npm i
```

#### Mix build
```sh
npm run dev
```

#### Database migrate and seed
Only when you start the project the first time, run
```sh
php artisan migrate --seed
```

#### Run server
```sh
php artisan storage:link
php artisan serve --host=0.0.0.0
```
