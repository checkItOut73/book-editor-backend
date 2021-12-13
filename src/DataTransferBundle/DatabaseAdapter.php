<?php declare(strict_types = 1);

namespace App\DataTransferBundle;

use PDO;

class DatabaseAdapter
{
    private PDO $databaseConnection;

    public function __construct(PDO $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;

        $this->databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getRow(string $sqlQuery): array
    {
        $statement = $this->databaseConnection->query($sqlQuery);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row ? $row : [];
    }

    public function getRows(string $sqlQuery): array
    {
        $rows = [];
        $statement = $this->databaseConnection->query($sqlQuery);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function executeQuery(string $sqlQuery)
    {
        $this->databaseConnection->exec($sqlQuery);
    }

    public function quote(string $string, int $type = PDO::PARAM_STR): string
    {
        return $this->databaseConnection->quote($string, $type);
    }
}
