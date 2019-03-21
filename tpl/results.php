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

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Интелект тестируемого</th>
        <th scope="col">Сложность (от-до)</th>
        <th scope="col">Результат</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        /** @var \Test\Result $result */
    foreach ($results as $result): ?>
        <tr>
            <th scope="row"><?= $result->getId() ?></th>
            <td><?= $result->intellect ?></td>
            <td><?= $result->minDifficulty .'-'. $result->maxDifficulty ?></td>
            <td><?= $result->result ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

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
