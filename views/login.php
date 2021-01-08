<?php 

    /** $model \app\models\LoginForm */
    
    use protonx\basemvc\core\form\Form;
    
    $this->title = 'Login';
?>

<h1>Login</h1>

<?php  

    $form = Form::begin('', 'post', $model);

    $email =  $form->inputField('email'); 
    $pw = $form->inputField('password')->passwordField(); 
    $form->zweierreihe($email, $pw);

    $form->submit('Anmelden');

    $form->end();

?>