<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteChapter\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteChapter\Repository\DeleteChapterRepository
 */
class DeleteChapterRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private DeleteChapterRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new DeleteChapterRepository($this->databaseAdapter);
    }

    public function testDeleteChapterPerformsTheCorrectQuery()
    {
        $this->repository->deleteChapter(5);

        $this->assertEquals(
            ['EXEC deleteChapter @chapterId = 5'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
