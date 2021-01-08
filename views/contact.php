<?php 

    /** @var $this \protonx\basemvc\core\View */
    /** @var $model \protonx\basemvc\models\ContactForm */

    use protonx\basemvc\core\form\Form;

    $this->title = 'Kontakt';

?>

<h1>Kontakt</h1>

<?php  

    $form = Form::begin('', 'post', $model);

    echo $form->inputField('subject');
    echo $form->inputField('email'); 
    echo $form->textAreaField('body');

    $form->submit('Abschicken');

    $form->end();

?>