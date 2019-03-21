<?php

namespace Test;


class Controller {

    const TPL_PATH = __DIR__ .'/../tpl/';
    
    /**
     * Отображает главную страницу теста
     */
    public function actionMain()
    {
        include_once self::TPL_PATH . 'main.php';
    }

    /**
     * Запускает новый тест и возвращает html результатов теста
     */
    public function actionStart()
    {
        if (
            !isset($_REQUEST['min_difficulty'], $_REQUEST['max_difficulty'], $_REQUEST['intellect'])
            || $_REQUEST['min_difficulty'] == ''
            || $_REQUEST['max_difficulty'] == ''
            || $_REQUEST['intellect'] == ''
            || $_REQUEST['min_difficulty'] > $_REQUEST['max_difficulty']
        ) {
            http_response_code(400);
            exit;
        }
        
        $test = new \Test\Test($_REQUEST['min_difficulty'], $_REQUEST['max_difficulty']);
        $testPerson = new \Test\TestPerson($_REQUEST['intellect']);

        list($results, $rightAnswers) = $test->run($testPerson);
        include_once self::TPL_PATH . 'result.php';
    }

    /**
     * Отображает таблицу результатов
     */
    public function actionResults()
    {
        $results = \Test\Result::getAll();
        include_once self::TPL_PATH . 'results.php';
    }
}