<?php
/**
 * Class  class m002_users_add_password_column
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc
 */

 class m002_users_add_password_column
 {
    public function __construct() {}

    public function up($pdo)
    {
        $sql = "
            ALTER TABLE users
            ADD COLUMN password VARCHAR(255) NOT NULL; 
        ";
        
        $pdo->exec($sql);
    }

    public function down($pdo) // Request $request
    {
        $sql = "
            ALTER TABLE users
            DROP COLUMN password; 
        ";
        
        $pdo->exec($sql);
    }
}