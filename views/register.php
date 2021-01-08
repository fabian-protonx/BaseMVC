<?php 

    /** $model \protonx\basemvc\models\User */

    use protonx\basemvc\core\form\Form;

    $this->title = 'Registrieren';
?>

<h1>Registrieren</h1>

<?php  

    $form = Form::begin('', 'post', $model);

    $vorname = $form->inputField('firstName');
    $nachname = $form->inputField('lastName');
    $form->zweierreihe($vorname, $nachname);

    echo $form->inputField('email'); 

    $pw1 = $form->inputField('password')->passwordField(); 
    $pw2 = $form->inputField('passwordConfirmed')->passwordField();
    $form->zweierreihe($pw1, $pw2);

    $form->submit('Registrieren');

    $form->end();

?>