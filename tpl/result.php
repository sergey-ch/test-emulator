<h3>Тестируемый ответил правильно на <?= $rightAnswers ?> вопросов из 40</h3>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">id</th>
        <th scope="col">Количество использований</th>
        <th scope="col">Сложность</th>
        <th scope="col">Правильный ответ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($results as $key => $result): ?> 
    <tr>
        <th scope="row"><?= $key + 1 ?></th>
        <td><?= $result['id'] ?></td>
        <td><?= $result['usage'] ?></td>
        <td><?= $result['difficulty'] ?></td>
        <td><?= $result['passed'] ? 'Да' : 'нет' ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>