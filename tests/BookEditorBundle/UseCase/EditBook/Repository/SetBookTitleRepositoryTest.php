<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\Repository\SetBookTitleRepository
 */
class SetBookTitleRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetBookTitleRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetBookTitleRepository($this->databaseAdapter);
    }

    public function testSetBookTitlePerformsTheCorrectQuery()
    {
        $this->repository->setBookTitle(5, 'An amazing story...');

        $this->assertEquals(
            ['EXEC setBookTitle @bookId = 5, @title = An amazing story... | quoted with 2'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
