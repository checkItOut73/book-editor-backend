<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditChapter\Repository\SetChapterHeadingRepository
 */
class SetChapterHeadingRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetChapterHeadingRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetChapterHeadingRepository($this->databaseAdapter);
    }

    public function testSetChapterHeadingPerformsTheCorrectQuery()
    {
        $this->repository->setChapterHeading(5, 'An amazing story...');

        $this->assertEquals(
            ['EXEC setChapterHeading @chapterId = 5, @heading = An amazing story... | quoted with 2'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
