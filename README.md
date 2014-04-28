Cooperation Social Network
==========================

This project is a simple social network for cooperation within an organization. It was developed as a school project.

## How to run the project

What you need to run the project:
- Web server with PHP>=5.4, on Windows you can use [Wampserver](http://www.wampserver.com/en/#download-wrapper)
- [PostgreSQL](http://www.postgresql.org/download/)
- [Composer](https://getcomposer.org/download/)

Steps to start web application:

1. Install the web server
2. Make sure you have enabled apache mod_rewrite module and pdo_pgsql PHP extension
3. Clone or download repository to the web directory of your web server (www, htdocs, public_html, ...).
4. Install PostgreSQL database. Create user **postgres** with password **1234**. On Windows this can be done during setup.
5. Run SQL script which creates tables: ```/src/SQL/create-tables.sql```
6. Install Composer.
7. Open terminal and move to the project directory. Then run command: ```composer update```.
8. Open browser and run the application ```http://localhost/<path_to_app>/web/```.
