<?php
/**
 * Class TextAreaField
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core\form;

use protonx\basemvc\core\Model;

class TextAreaField extends BaseField
{
    public Model $model;
    public string $name;

    public function __construct(Model $model, string $name)
    {
        $this->model = $model;
        $this->name = $name;
    }

    public function renderInput() : string
    {
        return sprintf('<textarea name="%s" class="form-control %s">%s</textarea>', 
        $this->name,
        $this->model->hasError($this->name) ? 'is-invalid' : '', 
        $this->model->{$this->name});
    }
}