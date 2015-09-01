<?php

return [
    'hostname' => HOSTNAME,
    'class' => [
        'Ngaji/Routing/Route.php',
        'Ngaji/Routing/Controller.php',
        'Ngaji/Http/Request.php',
        'Ngaji/Http/Response.php',
        'Ngaji/Http/Session.php',
        'Ngaji/View/View.php',
        # PDO
        'Ngaji/Database/Connection.php',
        'Ngaji/Database/ActiveRecord.php',
        'Ngaji/Database/QueryBuilder.php',
        # helpers
        'app/helpers/DateFormat.php',
        'app/helpers/Html.php',

        # register your class in here, with full directory path
        ''
    ],
    # database configuration
    'db' => [
        'driver' => 'sqlite', # replace it with 'mysql'
        'name' => '.../../db.sqlite3',
        'host' => '',
        'user' => '',
        'pass' => ''
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
    ]
];