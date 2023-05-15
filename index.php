<?php
// Valid PHP Version?
$minPHPVersion = '7.2';
if (phpversion() < $minPHPVersion) {
    die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}
unset($minPHPVersion);

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
ini_set("zlib.output_compression", "Off");
ini_set('memory_limit', '-1');


// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(FCPATH . '/app/Config/Paths.php');
// ^^^ Change this if you move your application folder
//echo $_SERVER["HTTP_HOST"];

//////////////////////////////////////////////////////////////////////////////////////////////////////////
$HTTPSDomains = ['panel.umrahfuras.com'];
$protocol = 'http';
if (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] != 'localhost') {
    if ($_SERVER["HTTPS"] != "on" && in_array($_SERVER["HTTP_HOST"], $HTTPSDomains)) {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    if (in_array($_SERVER["HTTP_HOST"], $HTTPSDomains)) {
        $protocol = 'https';
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER["HTTP_HOST"] == "localhost") {
    define('TEMPLATE', 'http://localhost/umrahfurasAT/template/');
    define('PATH', 'http://localhost/umrahfurasAT/');
    // define('DBDNS', 'postgresql://umrahfuras:root@127.0.0.1:5432/umrahfuras_maindb');
    define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@162.245.237.138:5432/umrahfuras_maindb');
    define('RESTAPI_URL','http://162.245.237.138/api/');
    
    //define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@173.249.41.108:5432/umrahfuras_maindb');



//    define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@111.68.99.227:5432/umrahfuras_maindb');

    error_reporting(1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    date_default_timezone_set('Europe/London');
} else if ($_SERVER["HTTP_HOST"] == "shaheryar-lala") {
    define('TEMPLATE', 'http://shaheryar-lala/umrahfuras.com/dashboard/template/');
    define('PATH', 'http://shaheryar-lala/umrahfuras.com/dashboard/');
    define('DBDNS', 'postgresql://postgres:aBv3MK3FpKc6e@161.97.85.3:5432/umrahfuras_maindb');
    define('RESTAPI_URL','http://162.245.237.138/api/');
}else if ($_SERVER["HTTP_HOST"] == "umrahfuras.test") {
    define('TEMPLATE', 'https://umrahfuras.test/dashboard/template/');
    define('PATH', 'https://umrahfuras.test/dashboard/');
    define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@111.68.99.227:5432/umrahfuras_maindb');
    define('RESTAPI_URL','http://162.245.237.138/api/');
}else if ($_SERVER["HTTP_HOST"] == "ping.tripplanner.ae") {
    define('TEMPLATE', 'http://ping.tripplanner.ae/template/');
    define('PATH', 'http://ping.tripplanner.ae/');
    define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@127.0.0.1:5432/umrahfuras_maindb');
    define('RESTAPI_URL','http://162.245.237.138/api/');
} else {
    define('TEMPLATE', $protocol . '://' . $_SERVER["HTTP_HOST"] . '/template/');
    define('PATH', $protocol . '://' . $_SERVER["HTTP_HOST"] . '/');
    define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@127.0.0.1:5432/umrahfuras_maindb');
    define('RESTAPI_URL','http://162.245.237.138/api/');
    //define('DBDNS', 'postgresql://umrahfuras:](UT-0k}6tEC@111.68.99.227:5432/umrahfuras_maindb'); /// Barani Uni Server
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
$app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();
