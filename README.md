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
2. Clone or download repository to the web directory of your web server (www, htdocs, public_html, ...).
3. Install PostgreSQL database. Create user **postgres** with password **1234**. On Windows this can be done during setup.
4. Run SQL script which creates tables: ```/src/SQL/create-tables.sql```
5. Install Composer.
6. Open terminal and move to the project directory. Then run command: ```composer update```.
7. Open browser and run the application ```http://localhost/<path_to_app>/web/```.
