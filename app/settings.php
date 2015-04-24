<?php

return [
    'hostname' => HOSTNAME,
    'class' => [
        'Ngaji/Routing/Route.php',
        'Ngaji/Routing/Router.php',
        'Ngaji/Routing/Controller.php',
        'Ngaji/Http/Request.php',
        'Ngaji/Http/Response.php',
        'Ngaji/View/View.php',
        # PDO
        'Ngaji/Database/Connection.php',
        'Ngaji/Database/ActiveRecord.php',
        'Ngaji/Database/QueryBuilder.php',
        # helpers
        'app/helpers/DateFormat.php',
        'app/helpers/Html.php',
        # controller
        'app/controllers/ApplicationController.php',

        # register your class in here, with full directory path
        ''
    ],
    # database configuration
    'db' => [
        'driver' => 'mysql',
        'name' => 'manajemen_resto',
        'host' => 'localhost',
        'user' => 'ockifals',
        'pass' => 'admin'
    ],
    # register your model class in here
    'models' => [
        'Accounts',
        'Items'
    ],
    # path for template(s)
    'template_path' => [
        'template'
    ],
    # path for static files (JS, CSS, font, etc.)
    'static' => [
        'assets'
    ],
    # templates name 
    'template_tags' => [
        'head' => 'head.php',
        'header' => 'header.php',
        'footer' => 'footer.php'
    ],
];