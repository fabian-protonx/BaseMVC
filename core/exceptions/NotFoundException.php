<?php
/**
 * Class NotFoundException
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\core\exceptions
 */

namespace protonx\basemvc\core\exceptions;

class NotFoundException extends \Exception 
{
    protected $message = 'Diese Seite wurde nicht gefunden!'; // Page not found

    protected $code = 404;
}