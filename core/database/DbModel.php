<?php
/**
 * Class DbModel
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\database
 */

namespace protonx\basemvc\core\database;

use protonx\basemvc\core\Model;
use protonx\basemvc\core\Application;

abstract class DbModel extends Model 
{
    abstract static public function tableName(): string;

    abstract static public function primaryKey(): string;
    
    abstract public function attributeList(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributeList();

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $implodedParams = implode(', ', $params); // :firstName, :lastName

        $attributeList = implode(', ', $attributes); // firstName, lastName

        $sql = "INSERT INTO $tableName ($attributeList) VALUES ($implodedParams);";

        $cmd = self::prepare($sql);

        foreach ($attributes as $attribute) 
        {
            $cmd->bindValue(":$attribute", $this->{$attribute});
        }

        $cmd->execute();

        return true;
    }

    public static function findOne($where) // [email => hallo@heaven.org, firstName = hallo]
    {
        $tableName = static::tableName(); // da die Funktion abstract ist

        $attributes = array_keys($where);

        $whereArray = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $whereClause = implode('AND', $whereArray);
        $sql = "SELECT * FROM $tableName WHERE $whereClause";
        $cmd = self::prepare($sql);

        foreach ($where as $key => $value) 
        {
            $cmd->bindValue(":$key", $value);
        }

        $cmd->execute();

        return $cmd->fetchObject(static::class); // gibt eine typisierte Antwort
        // https://www.php.net/manual/en/language.oop5.late-static-bindings.php
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}