<?php

class WordGuesser
{
    public $excludeLetters;
    public $knownLetters;
    public $start = 65;
    public $limit = 90;
    public $guessedWordsList = array();

    function __construct(array $excluded, array $letters)
    {
        $this->excludeLetters = $excluded;
        $this->knownLetters = $letters;
        // $this->knownWords = $this->getKnownWords();
    }

    public function guessWord()
    {
        $status = $this->getUnknownLettersCount();

        $guessedWordsList = [];
        if ($status->unknown_letters_count === 1) {
            $guessedWordsList = $this->singleWordLoop($status->positions);
        }

        if ($status->unknown_letters_count === 2) {
            $guessedWordsList = $this->doubleWordLoop($status->positions);
        }

        if ($status->unknown_letters_count === 3) {
            $guessedWordsList = $this->tripleWordLoop($status->positions);
        }

        if ($status->unknown_letters_count === 4) {
            $guessedWordsList = $this->quadWordLoop($status->positions);
        }

        return $guessedWordsList;
    }

    public function getUnknownLettersCount(): object
    {
        $count = 0;
        $positions = array();
        foreach ($this->knownLetters as $key => $value) {
            if ($value === '') {
                $count++;
                $positions[] = $key;
            }
        }
        return (object) array(
            'unknown_letters_count' => $count,
            'positions' => $positions
        );
    }

    public function singleWordLoop($unknownPositionsIndex): array
    {
        $postion = $unknownPositionsIndex[0];

        $knownWords = $this->getKnownWords($this->knownLetters[0]);

        for ($i = $this->start; $i <= $this->limit; $i++) {

            if (!in_array(chr($i), $this->excludeLetters)) {

                $this->knownLetters[$postion] = chr($i);
                $word = getWordInLowerCase($this->knownLetters);

                if (in_array($word, $knownWords)) {
                    array_push($this->guessedWordsList, $word);
                }
            }
        }

        return $this->guessedWordsList;
    }

    public function doubleWordLoop($unknownPositionsIndex): array
    {

        $indexOne = $unknownPositionsIndex[0];
        $indexTwo = $unknownPositionsIndex[1];

        $knownWords = $this->getKnownWords($this->knownLetters[0]);

        for ($i = $this->start; $i <= $this->limit; $i++) {

            if (!in_array(chr($i), $this->excludeLetters)) {

                $this->knownLetters[$indexOne] = chr($i);

                for ($j = $this->start; $j <= $this->limit; $j++) {

                    if (!in_array(chr($j), $this->excludeLetters)) {

                        $this->knownLetters[$indexTwo] = chr($j);

                        $word = getWordInLowerCase($this->knownLetters);

                        if (in_array($word, $knownWords)) {
                            array_push($this->guessedWordsList, $word);
                        }
                    }
                }
            }
        }
        return $this->guessedWordsList;
    }

    public function tripleWordLoop($unknownPositionsIndex): array
    {

        $indexOne = $unknownPositionsIndex[0];
        $indexTwo = $unknownPositionsIndex[1];
        $indexThree = $unknownPositionsIndex[2];

        $knownWords = $this->getKnownWords($this->knownLetters[0]);

        for ($i = $this->start; $i <= $this->limit; $i++) {

            if (!in_array(chr($i), $this->excludeLetters)) {

                $this->knownLetters[$indexOne] = chr($i);

                for ($j = $this->start; $j <= $this->limit; $j++) {

                    if (!in_array(chr($j), $this->excludeLetters)) {

                        $this->knownLetters[$indexTwo] = chr($j);

                        for ($k = $this->start; $k < $this->limit; $k++) {

                            if (!in_array(chr($k), $this->excludeLetters)) {

                                $this->knownLetters[$indexThree] = chr($k);
                                $word = getWordInLowerCase($this->knownLetters);

                                if (in_array($word, $knownWords)) {
                                    array_push($this->guessedWordsList, $word);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->guessedWordsList;
    }

    public function quadWordLoop($unknownPositionsIndex): array
    {

        $indexOne = $unknownPositionsIndex[0];
        $indexTwo = $unknownPositionsIndex[1];
        $indexThree = $unknownPositionsIndex[2];
        $indexFour = $unknownPositionsIndex[3];

        $knownWords = $this->getKnownWords($this->knownLetters[0]);

        for ($i = $this->start; $i <= $this->limit; $i++) {

            if (!in_array(chr($i), $this->excludeLetters)) {

                $this->knownLetters[$indexOne] = chr($i);

                for ($j = $this->start; $j <= $this->limit; $j++) {

                    if (!in_array(chr($j), $this->excludeLetters)) {

                        $this->knownLetters[$indexTwo] = chr($j);

                        for ($k = $this->start; $k <= $this->limit; $k++) {

                            $this->knownLetters[$indexThree] = chr($k);

                            if (!in_array(chr($k), $this->excludeLetters)) {

                                for ($l = $this->start; $l <= $this->limit; $l++) {

                                    if (!in_array(chr($l), $this->excludeLetters)) {

                                        $this->knownLetters[$indexFour] = chr($l);
                                        $word = getWordInLowerCase($this->knownLetters);

                                        if (in_array($word, $knownWords)) {
                                            array_push($this->guessedWordsList, $word);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->guessedWordsList;
    }

    public function getKnownWords($letter): array
    {
        if ($letter) {
            return json_decode(file_get_contents("words/words_collection/" . strtolower($letter) . ".json"));
        }

        $wordsList = [];
        for ($l = $this->start; $l <= $this->limit; $l++) {
            if (!in_array(chr($l), $this->excludeLetters)) {
                $words = json_decode(file_get_contents("words/words_collection/" . strtolower(chr($l)) . ".json"));
                if (count($words)) {
                    $wordsList[] = $words;
                }
            }
        }

        return array_merge(...$wordsList);
    }
}
