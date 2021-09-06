<?php

/**
 * VALIDAÇÕES
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

/**
 * DATABASE
 */
define("CONF_DB_HOST", 'localhost');
define("CONF_DB_USER", 'root');
define("CONF_DB_PASS", '');
define("CONF_DB_NAME", 'api');

/**
 * PROJECT URL
 */
define("DS", DIRECTORY_SEPARATOR);

/**
 * PROJECT TEMPLATE
 */
define("CONF_URL_BASE", __DIR__);
define("CONF_URL_PROJETO", 'php-api-rest-dev-home');
define("CONF_URL_BASEAPI", CONF_URL_BASE . CONF_URL_PROJETO);


if (file_exists('autoload.php')) {
  include 'autoload.php';
} else {
  echo "Erro ao incluir o boostrap";
  exit;
}
