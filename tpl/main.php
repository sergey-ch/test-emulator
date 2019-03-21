<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/assets/jquery-3.3.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <title>Test</title>
</head>
<body style="padding: 0 10px">
<h1></h1>

<div><a href="/?action=main">Тест</a> <a href="/?action=results">Результаты</a></div>

<form class="form-inline" id="testForm">
    <?php $min = rand(0, 100); $max = rand($min, 100) ?>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputMinDifficulty">Минимальная сложность</label>
            <input type="text" class="form-control" id="inputMinDifficulty" placeholder="Минимальная сложность" value="<?= $min ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="inputMaxDifficulty">Максимальная сложность</label>
            <input type="text" class="form-control" id="inputMaxDifficulty" placeholder="Максимальная сложность" value="<?= $max ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="inputIntellect">Интелект тестируемого</label>
            <input type="text" class="form-control" id="inputIntellect" placeholder="Интелект тестируемого" value="<?= rand(0, 100) ?>">
        </div>
        <button type="submit" id="start" class="btn btn-primary mb-2">Старт</button>
    </div>
</form>

<br>

<div id="result"></div>

<script type="text/javascript">
    $(document).on('submit', '#testForm', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/',
            method: 'POST',
            data: {
                action: 'start',
                min_difficulty: $('#inputMinDifficulty').val(),
                max_difficulty: $('#inputMaxDifficulty').val(),
                intellect: $('#inputIntellect').val()
            }
        }).done(function (response) {
            $('#result').html(response);
        }).fail(function () {
            $('#result').html('Ошибка');
        });
    });
</script>

</body>
</html>

<?php
