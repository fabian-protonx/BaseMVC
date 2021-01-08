<?php
/**
 * Class Database
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\database
 */

namespace protonx\basemvc\core\database;

use protonx\basemvc\core\Application;

class Database 
{
    public \PDO $pdo;

    public function __construct()
    {
        $dbConfig = Application::$CONFIG['Database'];

        // echo '<pre>';
        // var_dump(Application::$CONFIG);  
        // echo '</pre>';

        $dsn = $dbConfig['dsn'];
        $user = $dbConfig['user'];
        $password = $dbConfig['password'];

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // $this->applyMigrations();
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $this->getAppliedMigrations();

        $migrationsToApply = $this->getMigrationsToApply();

        $this->applyMigrationsToDatabase($migrationsToApply);

        exit;
    }

    private function createMigrationsTable()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS migrations 
            (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                createtAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
            ENGINE=INNODB;
        ";

        $this->pdo->exec($sql);
    }

    private function getMigrationsToApply()
    {
        $allMigrationFiles = $this->getMigrationFiles();

        // echo 'allMigrationFiles: <br />';
        // echo '<pre>';
        // var_dump($allMigrationFiles);  
        // echo '</pre>';

        $appliedMigrationFiles = $this->getAppliedMigrations();

        // echo 'appliedMigrationFiles: <br />';
        // echo '<pre>';
        // var_dump($appliedMigrationFiles);  
        // echo '</pre>';

        $migrationsToApply = array_diff($allMigrationFiles, $appliedMigrationFiles);

        // echo 'migrationsToApply: <br />';
        // echo '<pre>';
        // var_dump($migrationsToApply);  
        // echo '</pre>';

        return $migrationsToApply;
    }

    private function getAppliedMigrations()
    {
        $cmd = $this->pdo->prepare("
            SELECT migration FROM migrations
        ");
        $cmd->execute();

        return $cmd->fetchALL(\PDO::FETCH_COLUMN);
    }

    private function getMigrationFiles()
    {
        $files = scandir(Application::$ROOT_DIR . '/migrations');

        // echo '<pre>';
        // var_dump($files);  
        // echo '</pre>';

        return array_diff($files, ['..', '.']);
        // return $files = array_values($files); // with reordered indexes
    }

    private function applyMigrationsToDatabase($migrationsToApply)
    {
        $newMigrations = [];

        foreach ($migrationsToApply as $migration) 
        {
            // echo 'fileName: ' . $migration;
            // echo Application::$ROOT_DIR . '/migrations/' . $migration;
            $fileNamePath = Application::$ROOT_DIR . '/migrations/' . $migration;
            require_once $fileNamePath;
            
            $migrationClassName = pathinfo($fileNamePath, PATHINFO_FILENAME);
            // echo 'migrationClassName: ' . $migrationClassName . PHP_EOL;

            $instance = new $migrationClassName();

            $this->log('APPLY MIGRATION: ' . $migrationClassName);
            $instance->up($this->pdo);
            $this->log('MIGRATION APPLIED: ' . $migrationClassName);

            $newMigrations[] = $migration;
        }

        if(empty($newMigrations))
        {
            $this->log('Alle Migrations sind schon angewandt.');
        }
        else 
        {
            $this->saveMigrations($newMigrations);
        }
    }

    private function saveMigrations($newMigrations)
    {
        // echo '<pre>';
        // var_dump($newMigrations);  
        // echo '</pre>';

        $migrationStringArr  = array_map(fn($m) => "('" . $m . "')", $newMigrations);
        $migrationString = implode(",", $migrationStringArr);

        // echo '<pre>';
        // var_dump($migrationString);  
        // echo '</pre>';

        $cmd = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $migrationString");

        $cmd->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    protected function log($msg)
    {
        echo '[' . date('d.m.Y H:i:s') . '] - ' . $msg . PHP_EOL;
    }
}