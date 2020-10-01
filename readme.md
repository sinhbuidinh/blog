## Setup working
1/ Clone source
git clone https://github.com/sinhbuidinh/blog.git your_folder

2/ Install PHP package
- Install composer if not have.
- Run composer install for this code:
$ composer install

3/ Install Node package
- Install Node
- Install npm
- Install package:
$ npm install
- Running mix
$ npm run dev

## PROBLEM
1/ Class 'Barryvdh\Debugbar\ServiceProvider' not found in \src\Illuminate\Foundation\ProviderRepository.php #480
$ composer update barryvdh/laravel-debugbar
$ composer dump-autoload
