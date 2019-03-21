<?php

namespace Test;


class Test
{
    public $minDifficulty;
    public $maxDifficulty;
    public $questionsCount = 40;

    /**
     * @var Question[]
     */
    protected $questions;

    public function __construct($minDifficulty = null, $maxDifficulty = null, $questionsCount = null)
    {
        $this->minDifficulty = $minDifficulty;
        $this->maxDifficulty = $maxDifficulty;
        $this->questionsCount = $questionsCount ?: $this->questionsCount;
        
        // Получаем вопросы и подготавливаем вопросы
        $this->loadQuestions();
    }

    /**
     * Эмулирует прохождение теста
     * @param TestPerson $testPerson
     * @return array Данные о результатх тестирования
     */
    public function run(TestPerson $testPerson)
    {
        $ids = [];
        $rightAnswers = 0;
        $total = [];
        
        foreach ($this->questions as $key => $question) {
            $question->usage++;
            
            // массив с данными для таблицы
            $total[$key] = [
                'id' => $question->getId(),
                'usage' => $question->usage,
                'difficulty' => $question->difficulty,
                'passed' => 0
            ];
            
            // если это не самы сложный вопрос и уровень интелекта больше 0
            // то сверяем уровень интелекта со сложностью вопроса
            if (
                $testPerson->intellect != 0
                && $question->difficulty != 100
                && (
                    $testPerson->intellect == 100
                    || $question->difficulty == 0
                    || $this->checkAnswer($question->difficulty, $testPerson->intellect)
                )
            ) {
                $total[$key]['passed'] = 1;
                $rightAnswers++;
            }
            
            $ids[] = $question->getId();
        }
        
        // сохраняем результаты
        $result = new Result();
        $result->minDifficulty = $this->minDifficulty;
        $result->maxDifficulty = $this->maxDifficulty;
        $result->intellect = $testPerson->intellect;
        $result->result = $rightAnswers;
        $result->save();
        
        Question::incrementUsageById($ids);
        
        return [$total, $rightAnswers];
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Выбираем рандомные вопросы для теста
     * @return array|Question[]
     */
    protected function loadQuestions()
    {
        $questions = Question::getAll();
        $questions = $this->filterRandomQuestions($questions);
        $questions = $this->setQuestionsDifficulty($questions);
        
        $this->questions = $questions;
        
        return $questions;
    }

    public function filterRandomQuestions($questions)
    {
        $maxUsage = array_reduce($questions, function($carry, $question) {
            return $carry > $question->usage ? $carry : $question->usage;
        }, 0);

        if ($maxUsage > 0) {
            array_walk($questions, function ($question) use ($maxUsage) {
                $q = $question->usage / $maxUsage;
                $question->rand = rand($q * 100, 100);
            });

            usort($questions, function ($a, $b) {
                if ($a->rand == $b->rand) {
                    return 0;
                }

                return ($a->rand < $b->rand) ? -1 : 1;
            });
        } else {
            shuffle($questions);
        }

        $questions = array_slice($questions, 0, $this->questionsCount);
        
        return $questions;
    }

    /**
     * @param Question[] $questions
     * @return mixed
     */
    public function setQuestionsDifficulty($questions)
    {
        foreach ($questions as $question) {
            $question->difficulty = rand($this->minDifficulty, $this->maxDifficulty);
        }

        return $questions;
    }

    /**
     * роверяем вероятность ответа на вопрос
     * @param $difficulty
     * @param $intellect
     * @return bool
     */
    public function checkAnswer($difficulty, $intellect)
    {
        $x = rand(100 - $difficulty, 100);
        $y = rand(100 - $intellect, 100);
        
        if ($x >= $y) {
            return true;
        }
        
        return false;
    }
}