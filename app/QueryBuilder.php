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
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog2;charset=utf8;', 'root', '');
    }

    public function getString($table, $id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValues([
                'id' => $id,
            ]);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllowedComments()
    {
        $select = $this->queryFactory->newSelect();
        $select->cols([
            'users.username',
            'comments.date_comment',
            'users.user_photo',
            'comments.comment'
        ])
            ->from('comments')
            ->join(
                'INNER',             // the join-type
                'users',        // join to this table ...
                'comments.user_id = users.id' // ... ON these conditions
            )
            ->where('comments.access = 1');

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllComments()
    {
        $select = $this->queryFactory->newSelect();
        $select->cols([
            'comments.id',
            'comments.access',
            'users.username',
            'comments.date_comment',
            'users.user_photo',
            'comments.comment'
        ])
            ->from('comments')
            ->join(
                'INNER',             // the join-type
                'users',        // join to this table ...
                'comments.user_id = users.id' // ... ON these conditions
            );

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment()
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into('comments')
            ->cols([
                'comment' => $_POST['comment'],
                'user_id' => $_SESSION['auth_user_id'],
            ]);

        // prepare the statement
        $sth = $this->pdo->prepare($insert->getStatement());

        // execute with bound values
        $sth->execute($insert->getBindValues());
    }

    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id)
            ->bindValues($data);
        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());
    }
}