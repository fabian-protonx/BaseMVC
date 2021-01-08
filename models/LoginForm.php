<?php
/**
 * Class LoginForm
 * 
 * @author Fabian Suter <fabian.suter@protonx.ch>
 * @package protonx\basemvc\models
 */

namespace protonx\basemvc\models;

use protonx\basemvc\core\Model;
use protonx\basemvc\core\Application;

class LoginForm extends Model
{
    public string $email = '';

    public string $password = '';

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if(!$user)
        {
            $this->addError('email', 'Dieser Benutzer ist unbekannt!');

            return false;
        }

        if(!password_verify($this->password, $user->password))
        {
            $this->addError('password', 'Ihre Benutzerdaten sind nicht korrekt!');

            return false;
        }

        return Application::$app->login($user);
    }

    public function rules(): array
    {
        return [

            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels() : array 
    {
        return [
            'email' => 'Ihre E-Mail',
            'password' => 'Ihr Passwort'
        ];
    }
}