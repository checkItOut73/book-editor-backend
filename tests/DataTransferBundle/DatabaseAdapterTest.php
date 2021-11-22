<?php declare(strict_types = 1);

namespace App\DataTransferBundle;

use PDO;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseConnectionStub;
use Tests\DataTransferBundle\PDOStatementStub;

/**
 * @covers \App\DataTransferBundle\DatabaseAdapter
 */
class DatabaseAdapterTest extends TestCase
{
    private PDOStatementStub $pdoStatement;
    private DatabaseConnectionStub $databaseConnection;
    private DatabaseAdapter $databaseAdapter;

    public function setUp(): void
    {
        $this->pdoStatement = new PDOStatementStub();
        $this->databaseConnection = (new DatabaseConnectionStub())->setQueryResult($this->pdoStatement);
        $this->databaseAdapter = new DatabaseAdapter($this->databaseConnection);
    }

    public function testGetRowsPerformsTheCorrectQueryAndFetch()
    {
        $this->databaseAdapter->getRows('SELECT column1, column2 FROM [table]');

        $this->assertEquals(
            ['SELECT column1, column2 FROM [table]'],
            $this->databaseConnection->getQueryCalls()
        );
        $this->assertEquals(
            [
                [PDO::FETCH_ASSOC, null, null]
            ],
            $this->pdoStatement->getFetchCalls()
        );
    }

    public function testGetRowsReturnsTheRowsCorrectly()
    {
        $this->databaseConnection->setQueryResult(
            (new PDOStatementStub())
                ->setFetchResults([
                    [
                        'column1' => 'Clown',
                        'column2' => 'Kostüm'
                    ],
                    [
                        'column1' => 'Käse',
                        'column2' => 'Wurst'
                    ]
                ])
        );

        $this->assertEquals(
            [
                [
                    'column1' => 'Clown',
                    'column2' => 'Kostüm'
                ],
                [
                    'column1' => 'Käse',
                    'column2' => 'Wurst'
                ]
            ],
            $this->databaseAdapter->getRows('SELECT column1, column2 FROM [table]')
        );
    }
}
