<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

require_once dirname(__FILE__).'/../../Bachelor-Thesis/Source/bootstrap.php';
require_once dirname(__FILE__).'/{{ name }}/{{ name }}Application.php';

$app = new {{ name }}Application('prod', false);
$app->configure();
$app->run()->dispatch();
