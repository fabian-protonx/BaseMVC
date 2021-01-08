<?php
/**
 * Class InputField
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core\form;

use protonx\basemvc\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_EMAIL = 'email';

    public string $type = '';

    public function __construct(Model $model, string $name)
    {
        $this->type = self::TYPE_TEXT;

        parent::__construct($model, $name);
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;

        // damit können wir verkettete Aufrufe machen:
        // $pw1 = $form->field($model, 'password', 'Passwort')->passwordField();
        return $this;
    }

    public function renderInput() : string
    {
        return sprintf('<input type="%s" class="form-control %s" value="%s" id="%s" name="%s">', 
        $this->type,
        $this->model->hasError($this->name) ? 'is-invalid' : '', 
        $this->model->{$this->name}, 
        $this->name, 
        $this->name);
    }
}