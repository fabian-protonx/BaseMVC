<?php
/**
 * Class  class m001_init
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc
 */

 class m001_init
 {
    public function __construct() {}

    public function up($pdo)
    {
        $sql = "
            CREATE TABLE users
            (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                firstName VARCHAR(255) NOT NULL,
                lastName VARCHAR(255) NOT NULL,
                status TINYINT NOT NULL DEFAULT 0,
                createtAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) 
            ENGINE=INNODB; 
        ";
        
        $pdo->exec($sql);
        
        // echo self::class . " -> up()" . PHP_EOL;
    }

    public function down($pdo) // Request $request
    {
        $sql = "DROP TABLE users;";
        
        $pdo->exec($sql);

        // echo self::class . " -> down()" . PHP_EOL;
    }
}