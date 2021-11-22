<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use App\DataTransferBundle\DatabaseAdapter;

class DatabaseAdapterStub extends DatabaseAdapter
{
    private array $row = [];
    private array $rows = [];

    /** @var array<string> $getRowCalls */
    private array $getRowCalls = [];

    /** @var array<string> $getRowsCalls */
    private array $getRowsCalls = [];

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

    public function setRows(array $rows)
    {
        $this->rows = $rows;
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
}
