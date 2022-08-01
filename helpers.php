<?php

function dd(...$parms)
{
    echo '<pre>';
    print_r($parms);
    echo '</pre>';
    exit;
}

function clean_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getWordInLowerCase($arrOfLetters)
{
    return strtolower(implode('', $arrOfLetters));
}