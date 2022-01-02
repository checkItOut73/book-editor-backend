<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use App\DataTransferBundle\DatabaseAdapter;
use PDO;

class DatabaseAdapterStub extends DatabaseAdapter
{
    private array $row = [];
    private array $rows = [];
    private bool $executeQueryResult = false;

    /** @var array<string> $getRowCalls */
    private array $getRowCalls = [];

    /** @var array<string> $getRowsCalls */
    private array $getRowsCalls = [];

    /** @var array<array> $executeQueryCalls */
    private array $executeQueryCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setRow(array $row): DatabaseAdapterStub
    {
        $this->row = $row;

        return $this;
    }

    public function getRow(string $queryString): array
    {
        $this->getRowCalls[] = $queryString;

        return $this->row;
    }

    public function getGetRowCalls(): array
    {
        return $this->getRowCalls;
    }

    public function setRows(array $rows): DatabaseAdapterStub
    {
        $this->rows = $rows;

        return $this;
    }

    public function getRows(string $queryString): array
    {
        $this->getRowsCalls[] = $queryString;

        return $this->rows;
    }

    public function getGetRowsCalls(): array
    {
        return $this->getRowsCalls;
    }

    public function setExecuteQueryResult(bool $executeQueryResult): DatabaseAdapterStub
    {
        $this->executeQueryResult = $executeQueryResult;

        return $this;
    }

    public function executeQuery(string $sqlQuery)
    {
        $this->executeQueryCalls[] = $sqlQuery;

        return $this->executeQueryResult;
    }

    public function getExecuteQueryCalls(): array
    {
        return $this->executeQueryCalls;
    }

    public function quote(string $string, int $type = PDO::PARAM_STR): string
    {
        $this->quoteCalls[] = [$string, $type];

        return '\'' . $string . '\' | quoted with ' . $type;
    }
}
