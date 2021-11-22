<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use PDOStatement;

class PDOStatementStub extends PDOStatement
{
    private array $fetchResults = [];
    private array $fetchCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setFetchResults(array $fetchResults): PDOStatementStub
    {
        $this->fetchResults = $fetchResults;

        return $this;
    }

    /** @codingStandardsIgnoreStart */
    public function fetch($how = null, $orientation = null, $offset = null): mixed
    {
        $this->fetchCalls[] = [$how, $orientation, $offset];

        return array_shift($this->fetchResults);
    }
    /** @codingStandardsIgnoreEnd */

    public function getFetchCalls(): array
    {
        return $this->fetchCalls;
    }
}
