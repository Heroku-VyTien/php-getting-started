<?php

// Turn on all error reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require('../vendor/autoload.php');

echo "test mail here ";

//-------------------------- TEST MAIL ----------------------

require 'PHPMailer/class.phpmailer.php';

echo "aaaaaaaa";


// Instantiate a new PHPMailer 
$mail = new PHPMailer;

// Tell PHPMailer to use SMTP
$mail->isSMTP();

// Replace sender@example.com with your "From" address. 
// This address must be verified with Amazon SES.
$mail->setFrom('nguyen.tien@mulodo.com', 'Sender Name');

// Replace recipient@example.com with a "To" address. If your account 
// is still in the sandbox, this address must be verified.
// Also note that you can include several addAddress() lines to send
// email to multiple recipients.
$mail->addAddress('vytien@gmail.com', 'Recipient Name');

// Replace smtp_username with your Amazon SES SMTP user name.
$mail->Username = 'AKIAIM3HS7UUXEQ4GTPA';

// Replace smtp_password with your Amazon SES SMTP password.
$mail->Password = 'AqF6E+ZsiPdZd+mvMhkRgiQvQH7tGH9Ky5POVQCG63qX';
    
// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
$mail->addCustomHeader('X-SES-CONFIGURATION-SET', 'ConfigSet');
 
// If you're using Amazon SES in a region other than US West (Oregon), 
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
// endpoint in the appropriate region.
$mail->Host = 'email-smtp.us-east-1.amazonaws.com';

// The subject line of the email
$mail->Subject = 'Amazon SES test (SMTP interface accessed using PHP)';

// The HTML-formatted body of the email
$mail->Body = '<h1>Email Test</h1>
    <p>This email was sent through the 
    <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
    interface using the <a href="https://github.com/PHPMailer/PHPMailer">
    PHPMailer</a> class.</p>';

// Tells PHPMailer to use SMTP authentication
$mail->SMTPAuth = true;

// Enable TLS encryption over port 587
$mail->SMTPSecure = 'tls';
$mail->Port = 587; // 587

// Tells PHPMailer to send HTML-formatted email
$mail->isHTML(true);

// The alternative email body; this is only displayed when a recipient
// opens the email in a non-HTML email client. The \r\n represents a 
// line break.
$mail->AltBody = "Email Test\r\nThis email was sent through the 
    Amazon SES SMTP interface using the PHPMailer class.";

if(!$mail->send()) {
    echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
} else {
    echo "Email sent!" , PHP_EOL;
}




//-------------------------- TEST MAIL ----------------------


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
