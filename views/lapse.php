<?php 

/** @var \Exception */
// lapse.php -> error

    $html = '<h1>';
    $html .= 'HTTP ';
    $html .= $exception->getCode();
    $html .= '<br />';
    $html .= $exception->getMessage();
    $html .= '</h1>';

    echo $html;

?>