# ✨QRMan✨

Dynamic QR code, logo QR code generate, tracking QR code scan, hitmap dashboard and admin panel using [Laravel 9](https://laravel.com) framework, [Vuexy](https://themeforest.net/item/vuexy-vuejs-html-laravel-admin-dashboard-template/23328599) template, [endroid/qr-code](https://github.com/endroid/qr-code) library and [python](https://python.org).

This is based from a fork of https://github.com/devdreamsolution/laravel7-qrcode-campaign. We re trying to fix some problems with the webapp, add docker and fix the documentation since it can be a really useful tool internally and for the community. The tool has been already updated and improved substantially including:
- More recent versions of Laravel and PHP
- Docker support
- Fixed Logo QR Generation
- Possibility to change theme
- Possibility to change registration button
- Fixed some gui problems


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

### Docker

We suggest to use docker for an easy deployment, make sure to copy the example env files and then edit them accordingly to your needs:

```sh
cp .env.docker.example .env
nano .env

cp .env.laravel.example .env.laravel
nano .env.laravel
```
#### Notes regarding env files
- When you run the project the first time you should set variable **FIRST_TIME** to *TRUE*. It will be then automatically set to false.
- The variable **APP_ENV** should be set to *production* when you want to enforce HTTPS. Otherwise, leave *local* when testing without https.
- The variable **APP_DEBUG** should be set to *FALSE* unless you are actually debugging
- The variable **APP_REGISTRATION** can be set to to enable or disable the possibility to register new users from the login page.

Then run with docker-compose:

```sh
docker compose up -d
```

We suggest to move docker-compose and the env files in a separate location/repo for production.

If you are using a proxy remove the ports directive and point to port 8000.

### Manual

If you want to run manually ignore .env.docker.example and copy/edit .env.laravel.example:

```sh
cp .env.laravel.example .env
nano .env
```

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
