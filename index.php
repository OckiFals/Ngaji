<?php
/**
 * definisikan full direktori root
 * untuk include script: php, css, js
 */
define('ABSPATH', dirname(__FILE__));

/**
 * definisikan app root
 * untuk include resource: gambar, font, dll.
 */
define('HOSTNAME', '/' . basename(__DIR__));

require('app/bootstrap.php');
# load config
$config = require('app/settings.php');

# start the app
(new bootstrap)->setConfig($config)->start();