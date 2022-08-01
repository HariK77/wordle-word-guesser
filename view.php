<?php extract($data); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Guesser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        .navbar-brand {
            font-size: 2rem;
        }
    </style>
</head>

<body>
    <!-- As a heading -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <h1 class="navbar-brand mb-0 me-auto ms-auto">Word Guesser</h1>
        </div>
    </nav>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif ?>

                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="col">
                <h4>Give Some inputs</h4>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Enter the letters</label>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="l1" class="form-label">Enter first letter</label> -->
                            <input type="text" onkeydown="return /[A-Z]/i.test(event.key)" maxlength="1" class="form-control" id="l1" placeholder="letter 1">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="l2" class="form-label">Enter second letter</label> -->
                            <input type="text" onkeydown="return /[A-Z]/i.test(event.key)" maxlength="1" class="form-control" id="l2" placeholder="letter 2">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="l3" class="form-label">Enter third letter</label> -->
                            <input type="text" onkeydown="return /[A-Z]/i.test(event.key)" maxlength="1" class="form-control" id="l3" placeholder="letter 3">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="l4" class="form-label">Enter fourth letter</label> -->
                            <input type="text" onkeydown="return /[A-Z]/i.test(event.key)" maxlength="1" class="form-control" id="l4" placeholder="letter 4">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <!-- <label for="l5" class="form-label">Enter fifth letter</label> -->
                            <input type="text" onkeydown="return /[A-Z]/i.test(event.key)" maxlength="1" class="form-control" id="l5" placeholder="letter 5">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="excluded" class="form-label">Enter Excluded letters(comma seperated)</label>
                    <input type="text" class="form-control" id="excluded" placeholder="Enter excluded letters">
                </div>
                <button type="button" class="btn btn-primary me-3" id="guess-btn">Guess Word</button>
                <button type="button" class="btn btn-info" id="clear-btn">Clear</button>
            </div>
            <div class="col">
                <h4>Guessed Words List</h4>
                <hr>
                <?php if (count($words)) : ?>
                    <ol>
                        <?php foreach ($words as $word) : ?>
                            <li><?= strtoupper($word) ?></li>
                        <?php endforeach ?>
                    </ol>
                <?php else : ?>
                    <p>Note:</p>
                    <?php if ($count >= 1) : ?>
                        <p>Sorry, We were unable to guess the words, with combination provided.</p>
                    <?php else : ?>
                        <p>Please give us some guesses</p>
                        <ul>
                            <li>You should give atleast 1 or more letters.</li>
                            <li>Giving the excluded letters will make the guessing faster.</li>
                        </ul>
                    <?php endif; ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <script>
        const l1 = document.getElementById('l1');
        const l2 = document.getElementById('l2');
        const l3 = document.getElementById('l3');
        const l4 = document.getElementById('l4');
        const l5 = document.getElementById('l5');
        const excluded = document.getElementById('excluded');

        const guessBtn = document.getElementById('guess-btn');
        const clearBtn = document.getElementById('clear-btn');

        document.addEventListener('DOMContentLoaded', () => {
            let urlObject = new URL(window.location.href);

            for (let i = 1; i < 6; i++) {
                if (urlObject.searchParams.has('l' + i)) {
                    window['l' + i].value = urlObject.searchParams.get('l' + i);
                }
            }

            if (urlObject.searchParams.has('excluded')) {
                excluded.value = urlObject.searchParams.get('excluded');
            }
        });

        guessBtn.addEventListener('click', (e) => {

            e.target.disabled = true;

            const urlObject = new URL(window.location.href);

            for (let i = 1; i < 6; i++) {
                if (window['l' + i].value) {
                    urlObject.searchParams.set('l' + i, window['l' + i].value.trim());
                } else {
                    urlObject.searchParams.set('l' + i, '');
                }
            }

            urlObject.searchParams.set('excluded', excluded.value.trim());

            window.location = urlObject.href;
        });

        clearBtn.addEventListener('click', (e) => {
            window.location = window.location.href.split('?')[0];
        });

        for (let i = 1; i < 6; i++) {
            window['l' + i].addEventListener('keyup', (e) => {
                e.target.value = e.target.value.toUpperCase();
            })
        }
    </script>
</body>

</html>