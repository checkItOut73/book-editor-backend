<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use App\DataTransferBundle\DatabaseAdapter;

class DatabaseAdapterStub extends DatabaseAdapter
{
    private array $rows = [];

    /** @var array<string> $getRowsCalls */
    private array $getRowsCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
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
