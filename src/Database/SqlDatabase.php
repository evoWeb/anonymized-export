<?php
namespace Evoweb\AnonymizedExport\Database;

class SqlDatabase extends \Arrilot\DataAnonymization\Database\SqlDatabase
{
    /**
     * @param string $statement
     *
     * @return \PDOStatement
     */
    public function query($statement)
    {
        return $this->pdo->query($statement);
    }
}
