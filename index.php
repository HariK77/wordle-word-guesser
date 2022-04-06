<?php

session_start();

// $excludeLetters = ['R', 'O', 'U', 'G', 'H', 'L', 'W', 'E', 'R', 'F'];
// $knownLetters = ['', 'A', 'T', 'A', 'L'];
// http://localhost/word-guesser/index.php?exluded=R,O,U,G,H,L,W,E,R,F&l3=T&l4=A&l5=L

require "WordGuesser.php";
include "helpers.php";

$l1 = clean_data($_GET['l1']) ? clean_data($_GET['l1']) : '';
$l2 = clean_data($_GET['l2']) ? clean_data($_GET['l2']) : '';
$l3 = clean_data($_GET['l3']) ? clean_data($_GET['l3']) : '';
$l4 = clean_data($_GET['l4']) ? clean_data($_GET['l4']) : '';
$l5 = clean_data($_GET['l5']) ? clean_data($_GET['l5']) : '';

$letters = array($l1, $l2, $l3, $l4, $l5);
// dd($letters);
$count = 0;
foreach ($letters as $key => $value) {
    if ($value !== '') {
        $count++;
    }
}
$words = array();

if ($count >= 1) {
    $excluded = array_map('strtoupper', explode(',', clean_data($_GET['excluded'])));
    // print_r($excluded);exit;
    $wordGuesser = new WordGuesser($excluded, $letters);
    $words = $wordGuesser->guessWord();
}

$data['words'] = $words;
$data['count'] = $count;

include "view.php";