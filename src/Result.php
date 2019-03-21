<?php

namespace Test;


class Result
{
    protected $id;
    public $intellect;
    public $minDifficulty;
    public $maxDifficulty;
    public $result;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }
    
    protected function load($data) {
        $this->id = $data['id'];
        $this->intellect = $data['intellect'];
        $this->minDifficulty = $data['min_difficulty'];
        $this->maxDifficulty = $data['max_difficulty'];
        $this->result = $data['result'];
    }

    /**
     * @return self[]
     */
    public static function getAll()
    {
        $st = App::db()->query('SELECT * FROM result');
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);

        $results = array_map(function($result) {
            $q = new self();
            $q->load($result);
            
            return $q;
        }, $results);
        
        return $results;
    }

    public function save()
    {
        if ($this->id > 0) {
            return false;
        }
        
        $st = App::db()->prepare('
            INSERT INTO result (intellect, min_difficulty, max_difficulty, result)
             VALUES (:intellect, :min_difficulty, :max_difficulty, :result)
        ');

        $st->bindValue(':intellect', (int) $this->intellect, \PDO::PARAM_INT);
        $st->bindValue(':min_difficulty', (int) $this->minDifficulty, \PDO::PARAM_INT);
        $st->bindValue(':max_difficulty', (int) $this->maxDifficulty, \PDO::PARAM_INT);
        $st->bindValue(':result', (int) $this->result, \PDO::PARAM_INT);

        $st->execute();

        return $st->fetchAll();
    }
}