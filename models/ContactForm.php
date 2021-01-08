<?php
/**
 * Class ContactForm
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\models
 */

namespace protonx\basemvc\models;

use protonx\basemvc\core\Model;
use protonx\basemvc\core\Application;

class ContactForm extends Model
{
    public string $subject = '';

    public string $email = '';

    public string $body = '';

    public function send()
    {



        return true;
    }

    public function rules(): array
    {
        return [

            'subject' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'body' => [self::RULE_REQUIRED]
        ];
    }

    public function labels() : array 
    {
        return [
            'subject' => 'Subject',
            'email' => 'Ihre E-Mail',
            'body' => 'Ihre Nachricht'
        ];
    }
}