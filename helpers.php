<?php

function dd(...$parms)
{
    print_r($parms);
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