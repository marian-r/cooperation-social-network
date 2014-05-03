<?php

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->boot();
$connection = $kernel->getContainer()->get("database_connection");

require_once __DIR__.'/../src/SQL/SqlLoader.php';
PA036\SqlLoader::initDatabase($connection);
