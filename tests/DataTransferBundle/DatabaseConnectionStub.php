<?php declare(strict_types = 1);

namespace Tests\DataTransferBundle;

use PDO;
use PDOStatement;

class DatabaseConnectionStub extends PDO
{
    private PDOStatement $queryResult;

    /** @var array<string> $queryCalls */
    private array $queryCalls = [];

    /** @var array<string> $execCalls */
    private array $execCalls = [];

    /** @var array<array> $setAttributeCalls */
    private array $setAttributeCalls = [];

    /** @var array<array> $quoteCalls */
    private array $quoteCalls = [];

    public function __construct()
    {
        $this->queryResult = new PDOStatement();
        $this->prepareResult = new PDOStatement();
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

    public function exec(string $statement): bool
    {
        $this->execCalls[] = $statement;

        return true;
    }

    public function getExecCalls(): array
    {
        return $this->execCalls;
    }

    public function setAttribute(int $attribute, mixed $value): bool
    {
        $this->setAttributeCalls[] = [$attribute, $value];

        return true;
    }

    public function getSetAttributeCalls(): array
    {
        return $this->setAttributeCalls;
    }

    public function quote(string $string, int $type = PDO::PARAM_STR): string
    {
        $this->quoteCalls[] = [$string, $type];

        return $string . ' | quoted';
    }

    public function getQuoteCalls(): array
    {
        return $this->quoteCalls;
    }
}
