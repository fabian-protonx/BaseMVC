<?php
/**
 * Class Form
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core\form;

use protonx\basemvc\core\Model;

class Form 
{
    private ?Model $model = null;

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }

    public static function begin($action, $methode, $model)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $methode);

        return new Form($model);
    }

    public static function end()
    {
        echo '</form>';
    }

    public static function submit($titel)
    {
        echo '<button type="submit" class="btn btn-primary">' . $titel . '</button>';
    }

    public function inputField($name)
    {
        return new InputField($this->model, $name);
    }

    public function textAreaField($name)
    {
        return new TextAreaField($this->model, $name);
    }

    public function zweierreihe($one, $two)
    {
        echo sprintf('
            <div class="row">
                <div class="col">%s</div>
                <div class="col">%s</div>
            </div>
        ',
        $one, 
        $two);
    }
}