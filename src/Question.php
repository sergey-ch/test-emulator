<?php

namespace Test;


class Question
{
    protected $id;
    public $usage;
    public $difficulty;
    public $rand;

    public function __construct()
    {
        
    }

    public function getId()
    {
        return $this->id;
    }
    
    protected function load($data) {
        $this->id = $data['id'];
        $this->usage = $data['usage'];
    }

    /**
     * @return self[]
     */
    public static function getAll()
    {
        $st = App::db()->query('SELECT * FROM question');
        $questions = $st->fetchAll(\PDO::FETCH_ASSOC);
        
        $questions = array_map(function($question) {
            $q = new self();
            $q->load($question);
            
            return $q;
        }, $questions);
        
        return $questions;
    }
    
    public static function incrementUsageById(array $ids) {
        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $st = App::db()->prepare("UPDATE question SET `usage`=`usage`+1 WHERE id IN ($in)");
        
        foreach ($ids as $key => $id) {
            $st->bindValue($key + 1, (int) $id, \PDO::PARAM_INT);
        }

        $st->execute();
    }
}