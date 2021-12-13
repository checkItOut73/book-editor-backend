<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\Entity\Chapter;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository
 */
class SetChaptersRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetChaptersRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetChaptersRepository($this->databaseAdapter);
    }

    public function testSetChaptersPerformsTheCorrectQuery()
    {
        $this->repository->setChapters(
            5,
            [
                (new Chapter())
                    ->setId(432),
                (new Chapter())
                    ->setId(5934)
                    ->setHeading('Trust yourself'),
                (new Chapter())
                    ->setHeading('Don\'t hesitate')
            ]
        );

        $this->assertEquals(
            [
                'DECLARE @chapters ChaptersTable; ' .
                'INSERT @chapters VALUES (432, NULL), (5934, Trust yourself | quoted with 2), ' .
                    '(NULL, Don\'t hesitate | quoted with 2); ' .
                'EXEC setChapters @bookId = 5, @chapters;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }

    public function testSetChaptersDoesNotInsertIntoTempTableIfNoChaptersAreGiven()
    {
        $this->repository->setChapters(
            5,
            []
        );

        $this->assertEquals(
            [
                'DECLARE @chapters ChaptersTable; EXEC setChapters @bookId = 5, @chapters;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
