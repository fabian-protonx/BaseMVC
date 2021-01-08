<?php
/**
 * Class ForbiddenException
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\exceptions
 */

namespace protonx\basemvc\core\exceptions;

class ForbiddenException extends \Exception 
{
    protected $message = 'Sie haben keine Berechtigungen für diese Seite!';

    protected $code = 403;
}