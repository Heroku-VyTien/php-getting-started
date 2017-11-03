<?php

require('../vendor/autoload.php');

// Connect Heroku Database
// extract(parse_url($_ENV["DATABASE_URL"]));
// var_dump("user=$user password=$pass host=$host dbname=" . substr($path, 1));
connectDB();
function connectDB() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  
  $servername = $host;
  $username = $user;
  $password = $pass;
  $dbname = substr($path, 1);

// Create connection
  $conn = mysqli_connect($servername, $username, $password);

// Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  echo "Connected successfully";
}
// Connect Heroku Database
exit;

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->run();
