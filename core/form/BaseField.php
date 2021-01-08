<?php
/**
 * Class BaseField
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core\form;

use protonx\basemvc\core\Model;

abstract class BaseField 
{
    public Model $model;
    public string $name;

    abstract public function renderInput(): string;

    public function __construct(Model $model, string $name)
    {
        // echo '<pre>';
        // var_dump($model);  
        // echo '</pre>';

        $this->model = $model;
        $this->name = $name;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label for="%s">%s</label>
                %s
                <div class="invalid-feedback">%s</div>
            </div>
        ', 
        $this->name, 
        $this->model->labels()[$this->name] ?? $this->name, 
        $this->renderInput(),
        $this->model->getFirstError($this->name));
    }
}