<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use PDO;
use PDOStatement;

class DatabaseConnectionStub extends PDO
{
    private PDOStatement $queryResult;

    /** @var array<string> $queryCalls */
    private array $queryCalls = [];

    public function __construct()
    {
        $this->queryResult = new PDOStatement();
    }

    public function setQueryResult(PDOStatement $queryResult): DatabaseConnectionStub
    {
        $this->queryResult = $queryResult;

        return $this;
    }

    /** @codingStandardsIgnoreStart */
    public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement
    {
        $this->queryCalls[] = $query;

        return $this->queryResult;
    }
    /** @codingStandardsIgnoreEnd */

    public function getQueryCalls(): array
    {
        return $this->queryCalls;
    }
}
