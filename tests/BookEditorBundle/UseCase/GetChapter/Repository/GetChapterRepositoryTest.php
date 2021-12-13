<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter\Repository;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetChapter\Exception\ChapterNotFoundException;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetChapter\Repository\GetChapterRepository
 */
class GetChapterRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetChapterRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = (new DatabaseAdapterStub())
            ->setRow([
                'id' => '5',
                'number' => '2',
                'heading' => 'Die Kuh macht muh'
            ]);

        $this->repository = new GetChapterRepository($this->databaseAdapter);
    }

    public function testGetChapterPerformsTheCorrectQuery()
    {
        $this->repository->getChapter(5);

        $this->assertEquals(
            ['EXEC getChapter @chapterId = 5'],
            $this->databaseAdapter->getGetRowCalls()
        );
    }

    public function testGetChapterThrowsAnExceptionIfThereIsNoChapterWithTheGivenId()
    {
        $this->expectException(ChapterNotFoundException::class);
        $this->expectExceptionMessage('There is no chapter with id 5!');

        $this->databaseAdapter->setRow([]);

        $this->repository->getChapter(5);
    }

    public function testGetChapterReturnsTheCorrectData()
    {
        $this->assertEquals(
            (new Chapter())
                ->setId(5)
                ->setNumber(2)
                ->setHeading('Die Kuh macht muh'),
            $this->repository->getChapter(5)
        );
    }
}
