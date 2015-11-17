<?php
require '../vendor/autoload.php';
// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
  //  'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Slim-Skeleton '/' route");
    // Render index view
  /*  $fb = new Facebook\Facebook([
      'app_id' => '612396988819496',
      'app_secret' => 'e2ab814a26b255a01ee2bc59fe8f3995',
      'default_graph_version' => 'v2.5',
      //'default_access_token' => 'CAACEdEose0cBAG0EKeSizA0it5Uyl8yCx6srPtiBODkAVzgWeO4xCAuE8VZARl4Q70j08rxbkJ6gSBNH8NPISn2maMZANSimgPqEtE2cABjF6jf51FDzxxN1LgOlFOenQNQDz0ZB29pFXP6lvFKVjrrBatAjv6LyStxjfFMSuC1b9SogFHYoLqpOWzGATXr4JyqhzsMKABXVtnZAmJYZA', // optional
    ]);

    $fbApp = new Facebook\FacebookApp('612396988819496', 'e2ab814a26b255a01ee2bc59fe8f3995');


   try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me', 'CAACEdEose0cBAG0EKeSizA0it5Uyl8yCx6srPtiBODkAVzgWeO4xCAuE8VZARl4Q70j08rxbkJ6gSBNH8NPISn2maMZANSimgPqEtE2cABjF6jf51FDzxxN1LgOlFOenQNQDz0ZB29pFXP6lvFKVjrrBatAjv6LyStxjfFMSuC1b9SogFHYoLqpOWzGATXr4JyqhzsMKABXVtnZAmJYZA');
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $user = $response->getGraphUser();

    echo 'Name: ' . $user['name'];

*/

    $app->render('index.html');
});

// Run app
$app->run();
