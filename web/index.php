<?php

require('../vendor/autoload.php');

// Connect Heroku Database
// extract(parse_url($_ENV["DATABASE_URL"]));
// var_dump("user=$user password=$pass host=$host dbname=" . substr($path, 1));
connectDB();
function connectDB() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  
  // $con = pg_connect("host=ec2-50-19-118-164.compute-1.amazonaws.com port=5432 dbname=d208ios6flp4ak user=duivgyauhxqtbv password=8e67d8add13fbdb6b5348ecfe0df9ec1592bd6329f9ed6de437b481e3799647d");
  $con = pg_connect("host=$host port=5432 dbname=".substr($path, 1)." user=$user password=$pass");

   if (!$con) 
   {
     echo "Database connection failed.";
   }
   else 
   {
     echo "Database connection success.";
   }
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
