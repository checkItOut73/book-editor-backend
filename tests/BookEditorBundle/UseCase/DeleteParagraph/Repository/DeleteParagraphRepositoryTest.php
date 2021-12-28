<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteParagraph\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteParagraph\Repository\DeleteParagraphRepository
 */
class DeleteParagraphRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private DeleteParagraphRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new DeleteParagraphRepository($this->databaseAdapter);
    }

    public function testDeleteParagraphPerformsTheCorrectQuery()
    {
        $this->repository->deleteParagraph(5);

        $this->assertEquals(
            ['EXEC deleteParagraph @paragraphId = 5'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
