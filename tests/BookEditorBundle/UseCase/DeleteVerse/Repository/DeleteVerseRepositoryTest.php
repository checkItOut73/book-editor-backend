<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteVerse\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteVerse\Repository\DeleteVerseRepository
 */
class DeleteVerseRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private DeleteVerseRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new DeleteVerseRepository($this->databaseAdapter);
    }

    public function testDeleteVersePerformsTheCorrectQuery()
    {
        $this->repository->deleteVerse(5);

        $this->assertEquals(
            ['EXEC deleteVerse @verseId = 5'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
