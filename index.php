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
define('HOSTNAME', '/manajemen_resto');

require('app/bootstrap2.php');
# load config
$config = require('app/settings.php');

# start the app
(new bootstrap2)->setConfig($config)->start();
// $app = new bootstrap2();
// $app->setConfig($config)->start();