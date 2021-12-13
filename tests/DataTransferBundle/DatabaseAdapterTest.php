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
    private PDOStatementStub $queryPdoStatement;
    private DatabaseConnectionStub $databaseConnection;
    private DatabaseAdapter $databaseAdapter;

    public function setUp(): void
    {
        $this->queryPdoStatement = new PDOStatementStub();
        $this->preparePdoStatement = new PDOStatementStub();
        $this->databaseConnection = (new DatabaseConnectionStub())
            ->setQueryResult($this->queryPdoStatement);
        $this->databaseAdapter = new DatabaseAdapter($this->databaseConnection);
    }

    public function testDatabaseConnectionIsChangedToExceptionErrorMode()
    {
        $this->assertEquals(
            [
                [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]
            ],
            $this->databaseConnection->getSetAttributeCalls(),
        );
    }

    public function testGetRowPerformsTheCorrectQueryAndFetch()
    {
        $this->databaseAdapter->getRow('SELECT column1, column2 FROM [table]');

        $this->assertEquals(
            ['SELECT column1, column2 FROM [table]'],
            $this->databaseConnection->getQueryCalls()
        );
        $this->assertEquals(
            [
                [PDO::FETCH_ASSOC, null, null]
            ],
            $this->queryPdoStatement->getFetchCalls()
        );
    }

    public function testGetRowReturnsTheRowCorrectly()
    {
        $this->databaseConnection->setQueryResult(
            (new PDOStatementStub())
                ->setFetchResults([
                    [
                        'column1' => 'Clown',
                        'column2' => 'Kostüm'
                    ]
                ])
        );

        $this->assertEquals(
            [
                'column1' => 'Clown',
                'column2' => 'Kostüm'
            ],
            $this->databaseAdapter->getRow('SELECT column1, column2 FROM [table]')
        );
    }

    public function testGetRowReturnsEmptyArrayIfFetchHasNoResult()
    {
        $this->databaseConnection->setQueryResult(
            (new PDOStatementStub())
                ->setFetchResults([
                    false
                ])
        );

        $this->assertEquals(
            [],
            $this->databaseAdapter->getRow('SELECT column1, column2 FROM [table]')
        );
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
            $this->queryPdoStatement->getFetchCalls()
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

    public function testExecuteQueryExecutesTheStatementCorrectly()
    {
        $this->databaseAdapter->executeQuery(
            'INSERT INTO books VALUES ("The golden crown", "No one knows the truth...")'
        );

        $this->assertEquals(
            [
                'INSERT INTO books VALUES ("The golden crown", "No one knows the truth...")'
            ],
            $this->databaseConnection->getExecCalls()
        );
    }

    public function testQuoteCallsPdoQuoteCorrectly()
    {
        $this->databaseAdapter->quote('This is a string to be quoted!', PDO::PARAM_STR_NATL);

        $this->assertEquals(
            [
                ['This is a string to be quoted!', PDO::PARAM_STR_NATL]
            ],
            $this->databaseConnection->getQuoteCalls()
        );
    }

    public function testQuoteCallsPdoQuoteCorrectlyWithDefaultType()
    {
        $this->databaseAdapter->quote('This is a string to be quoted!');

        $this->assertEquals(
            [
                ['This is a string to be quoted!', PDO::PARAM_STR]
            ],
            $this->databaseConnection->getQuoteCalls()
        );
    }

    public function testQuoteReturnsQuotedStringCorrectly()
    {
        $this->assertEquals(
            'This is a string to be quoted! | quoted',
            $this->databaseAdapter->quote('This is a string to be quoted!', PDO::PARAM_STR_NATL)
        );
    }
}
