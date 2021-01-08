<?php
/**
 * Class Migrations
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package app
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// display_errors = on

require_once __DIR__ . '/vendor/autoload.php';

use protonx\basemvc\core\Application;

class Migrations 
{
    public function run()
    {
        $rootPath = __DIR__;

        $app = new Application($rootPath);

        $app->db->applyMigrations();
    }
}

$migrations = new Migrations();
$migrations->run();