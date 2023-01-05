<!--
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs

sail composer require dusterio/link-preview

sail artisan make:controller ScreenShotController --invokable

sail artisan make:model Site -a

sail artisan make:model SiteTag

sail artisan migrate:fresh --seed
sail artisan site:access
sail php artisan migrate:fresh --env=testing

sail artisan make:command SiteAccessCommand

sail artisan schedule:list

* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
sail artisan schedule:run

sail artisan storage:link


composer require kub-at/php-simple-html-dom-parser


sail artisan cache:clear
sail artisan config:clear
sail artisan route:clear
sail artisan view:clear

sail composer require --dev laravel/dusk
sail artisan dusk:install
sail dusk

sail composer require --dev barryvdh/laravel-ide-helper
sail artisan ide-helper:model --nowrite
sail artisan ide-helper:generate
sail artisan ide-helper:meta

sail artisan sail:publish
sudo apt-get install ubuntu-desktop
sudo apt-get install xvfb
sudo apt-get install cutycapt

sudo apt-get install tesseract-ocr tesseract-ocr-jpn
sudo apt-get install tesseract-ocr-jpn-*
sudo apt-get install gimagereader
sail composer require thiagoalessio/tesseract_ocr

sail artisan make:model SiteColor -m
sail composer require league/color-extractor
sail artisan make:event SiteSaved

sail composer require barryvdh/laravel-debugbar

sudo apt-get install mecab
sudo apt-get install libmecab-dev

Dockerfileから削除
    # && apt-get install -y ubuntu-desktop \
    # && apt-get install -y xvfb \
    # && apt-get install -y cutycapt \
    # && apt-get install -y tesseract-ocr tesseract-ocr-jpn \
    # && apt-get install -y tesseract-ocr-jpn-* \
    # && apt-get install -y gimagereader \

sail artisan make:migration create_site_tag_table
sail artisan make:model Tag -m


sail artisan make:component Sidebar

sail npm install js-cookie

sail artisan make:migration create_site_user_table

sail artisan make:controller Api/SiteUserController

sail composer require laravel/ui
sail artisan make:model Admin -ms
sail artisan migrate
sail artisan db:seed --class=AdminSeeder
sail artisan make:controller Admin/SiteController

sail npm install jquery –save
sail npm i spectrum-colorpicker

sail artisan vendor:publish --tag=laravel-pagination

sail npm install -D tailwindcss postcss autoprefixer
sail npx tailwindcss init -p
sail npm install -D @tailwindcss/forms

sail composer require intervention/image
sail artisan make:request UpdateTagsRequest
sail artisan make:request UpdateColorsRequest
-->
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
