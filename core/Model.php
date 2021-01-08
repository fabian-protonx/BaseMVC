<?php
/**
 * Class RegisterModel
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

 namespace protonx\basemvc\core;

 abstract class Model 
 {
     public const RULE_REQUIRED = 'required';
     public const RULE_EMAIL = 'email';
     public const RULE_MIN = 'min';
     public const RULE_MAX = 'max';
     public const RULE_MATCH = 'match';
     public const RULE_UNIQUE = 'unique';

    // public function __construct() {}

    public function loadData($data)
    {
        foreach ($data as $key => $value) 
        {
            if(property_exists($this, $key)) // php function
            {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function labels(): array 
    {
        return [];
    }

    public function getLabel($name) 
    {
        return $this->labels()[$name] ?? $name;
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {  //  attribute -> variabelName
       
            $value = $this->{$attribute};

            foreach ($rules as $rule) {

                $ruleName = $rule;

                if(is_array($ruleName))
                {
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }

                if($ruleName === self::RULE_UNIQUE)
                {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $sql = "SELECT * FROM $tableName WHERE $uniqueAttribute = :$uniqueAttribute";
                    $cmd = Application::$app->db->prepare($sql);
                    $cmd->bindValue(":$uniqueAttribute", $value);
                    $cmd->execute();
                    $record = $cmd->fetchObject();

                    if($record)
                    {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    // TODO: bessere Lösung
    private function addErrorForRule(string $attribute, string $ruleType, $rules = [])
    {
        $message = $this->errorMessages()[$ruleType] ?? '';

        foreach ($rules as $key => $value) 
        {
            $label = $this->getLabel($value);

            $message = str_replace("{{$key}}", $label, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function addError($attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    private function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'Dies ist ein Pflichtfeld!',
            self::RULE_EMAIL => 'Die E-Mail-Adress ist nicht gülig!',
            self::RULE_MIN => 'Die Länge muss mindestens {min} Zeichen enthalten!',
            self::RULE_MAX => 'Die Länge darf maximal {max} Zeichen enthalten!',
            self::RULE_MATCH => 'Dieses Feld hat nicht den gleichen Wert wie das Feld "{match}"',
            self::RULE_UNIQUE => 'Der Datensatz des Feld "{field}" ist schon vorhanden .'
        ];
    }

    public function hasError($name)
    {
        return $this->errors[$name] ?? false;
    }

    public function getFirstError($name)
    {
        return $this->errors[$name][0] ?? false;
    }
}