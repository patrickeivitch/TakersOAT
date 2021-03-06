<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


if (PHP_SAPI == 'cli-server') 
{
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

$app->get('/takers/{format}', function(Request $request, Response $response, array $args)
{         
    if (isset($args['format']) && $args['format'] === 'json')
    {        
        $file = __DIR__ . '/../files/testtakers.json';
        $content = file_get_contents($file);
        echo json_encode($content);
    }
    else 
    {
        //To do next time
    }
    //We can also use switch for many type formats files ...
});

    // Run app
    $app->run();

