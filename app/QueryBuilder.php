<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $queryFactory;
    private $pdo;

    public function __construct()
    {
        $this->queryFactory = new QueryFactory('mysql');
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8;', 'root', '');
    }

    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])->from($table);
        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}