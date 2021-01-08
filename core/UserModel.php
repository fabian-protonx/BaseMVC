<?php
/**
 * Class UserModel
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core
 */

namespace protonx\basemvc\core;

use protonx\basemvc\core\database\DbModel;

abstract class UserModel extends DbModel 
{
    abstract public function getDisplayName(): string;
}