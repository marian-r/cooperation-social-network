Cooperation Social Network
==========================

## What is it?

This project is a simple social network for cooperation within an organization. It allows registered users to create groups, submit posts within groups, and comment or like the posts. Next, users can send messages to each other and organize them into conversations.
This application was developed as a school project.


## About technologies

This is a PHP-based web application which uses:
- [Symfony2](http://symfony.com/) PHP web framework
- [Doctrine2](http://www.doctrine-project.org/) ORM library
- [Twig](http://twig.sensiolabs.org/) template engine
- [Bootstrap 3](http://getbootstrap.com/) front-end framework
- [PostgreSQL](http://www.postgresql.org/download/) database and its [PL/pgSQL](http://www.postgresql.org/docs/9.3/static/plpgsql.html) features
- [Composer](https://getcomposer.org/download/) dependency manager


## How to run the project

What you need to run the project:
- Web server with PHP>=5.4, on Windows you can use [Wampserver](http://www.wampserver.com/en/#download-wrapper)
- [PostgreSQL](http://www.postgresql.org/download/)
- [Composer](https://getcomposer.org/download/)

Steps to start web application:

1. Install the web server
2. Make sure you have enabled apache **mod_rewrite** module and **pdo_pgsql** PHP extension
3. Clone or download repository to the web directory of your web server (www, htdocs, public_html, ...).
4. Install PostgreSQL database. Create user **postgres** with password **1234**. On Windows this can be done during setup.
5. Install Composer.
6. Open terminal and move to the project directory. Then run command: ```composer update```.
7. Run SQL scripts with command: ```php bin/db-init.php```. This will also populate database tables with sample data.
8. Build assets files (JavaScript, CSS, etc.) with command: ```php app/console assetic:dump```.
9. Open browser and run the application ```http://localhost/<path_to_app>/web/```.


##How to run tests

1. Download [PHPUnit](http://phpunit.de/#download)
2. Run all tests ```php <path_to_php_unit>/phpunit.phar -c <path_to_app>/app```

