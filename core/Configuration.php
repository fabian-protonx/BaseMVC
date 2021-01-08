<?php
/**
 * Class Configuration
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

 namespace protonx\basemvc\core;

 class Configuration 
 {
    public static function getConfig()
    {
        $configFile = "config.json";
        $configPath = '';

        if(file_exists("../" . $configFile)) 
            $configPath = "../" . $configFile;
        else if(file_exists("./" . $configPath)) 
            $configPath = "./" . $configFile;
        else 
        {
            echo "Die Konfigurationsdatei config.json kann nicht gefunden werden!";
            exit;
        }

        $json = file_get_contents($configPath);
        $config = json_decode($json, true);

        return $config;
    }
}