<?php
    $point = 0;
    if(array_key_exists('answer', $_GET)){
        if($_GET['answer'] === 'Answer A') $point += 10;
    }
    echo $point;
?>