A project created during Software Engineering course in university.

PHP, Laravel.

# Project description

RobLeg is an annual contest for teams of two 7-12 years old children. They construct a LEGO robot and participate in several competitions.

- Sumo: Two robots try to force each other out of the ring (circle). The competition consists of several rounds, winners go to the next round until no more teams left.
- Obstacles course: Robots ride through a path avoiding obstacles, walls. Teams that arrive to the finish faster win.

A website is needed to display current and old contests results as well as news/reports, photos, information (rules, description, …).

During the contest period it allows teams to apply (by sending team information and teacher/curator contact info), either to one or both of the competitions.

During the contest administrator enters each competition/round results, and they are available to the users.

Admin is authenticated using password (by default admin, pass123). The authentication form is accessible by /admin-login URL.

# Development setup

For development you can either use Homestead virtual machine (via Vagrant) or manually install all needed tools.

## Vagrant

 1. Install VirtualBox and Vagrant.
 2. Install PHP (just interpreter, server not needed) and Composer. Go to the project root, run `composer install` and `php vendor/bin/homestead make` (for Windows `vendor\\bin\\homestead make`) to generate configuration file (`Homestead.yaml`).
  - Alternatively, you can follow Laravel Homestead documentation to install Homestead globally, it should not require PHP. https://laravel.com/docs/5.3/homestead
 3. Add `robcontest` and `robcontest-test` databases to Homestead.yaml.
 ```
 databases:
     - robcontest
     - robcontest-test
 ```
 4. Run `vagrant up`, this should download, configure and launch the virtual machine. Follow Laravel Homestead and Vagrant documentation if it fails.
 5. Use SSH client (such as Putty on Windows) and private key (should be in `.vagrant/machines/default/virtualbox` by default, or check vagrant output) to connect into it.

## Without Vagrant

1. Install PHP 7+, MySQL, web server such as Apache or nginx (or a WAMP/LAMP/MAMP package), Composer, Node.js/NPM.
2. Configure web server to serve `public` folder as its root.
 - Also you can use `php artisan serve` for built-in development web server instead of installing a web server.
3. Create MySQL databases: `robcontest` (of whatever you configured in `.env` file) and `robcontest-test` (optional, see below). 

## Configuration

 1. Copy and rename `.env.example` file to `.env`, change if needed (database user, address, APP_DEBUG, APP_ENV `local` or `production`). APP_DEBUG and APP_ENV are set to `false` and `production` if not present.
 2. Run `php artisan key:generate` to set key for session encryption (or set manually if you already have it).
 
## Build

 1. Run `composer install` to install PHP dependencies.
 2. Run `npm install` (or `yarn`) to install the rest of dependencies.
 3. Run `php artisan migrate` to apply database migrations.
 5. Run `npm run build` to build frontend (WebPack, SASS, ES6, ...). `npm run prod` builds for "production" (minimized files, etc.). `npm run watch` can be used to rebuild automatically on file changes. 
 6. Go to http://localhost:8000 (for default Homestead settings or if using `php artisan serve`), it should work.
 
# Tests

Most of the project is covered by automated tests (PHPUnit), tests are executed in all npm scripts described above.

Database is required for all tests, by default it uses MySQL with name `robcontest_test`, you can also use in-memory SQLite database by changing `DB_CONNECTION` to `sqlite` in `phpunit.xml` (much slower because cannot use transactions).

Name and user of testing MySQL database can be changed by adding `DB_DATABASE_TEST`, `DB_USERNAME_TEST`, `DB_PASSWORD_TEST` to `.env`, by default username and password are the same as for the main database, set in `DB_USERNAME`/`DB_PASSWORD`.
 
Be careful not to run tests twice at the same time (for example by `watch` and from IDE), they will fail and sometimes migrations may become "corrupted", so you may need to delete and create test database again manually.

