<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetParagraph\Exception\ParagraphNotFoundException;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetParagraph\Repository\GetParagraphRepository
 */
class GetParagraphRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetParagraphRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = (new DatabaseAdapterStub())
            ->setRow([
                'id' => '5',
                'numberInChapter' => '2',
                'verseNumberInChapterOffset' => '89432',
                'heading' => 'Die Kuh macht muh',
                'chapterId' => '2',
                'bookId' => '1'
            ]);

        $this->repository = new GetParagraphRepository($this->databaseAdapter);
    }

    public function testGetParagraphPerformsTheCorrectQuery()
    {
        $this->repository->getParagraph(5);

        $this->assertEquals(
            ['EXEC getParagraph @paragraphId = 5'],
            $this->databaseAdapter->getGetRowCalls()
        );
    }

    public function testGetParagraphThrowsAnExceptionIfThereIsNoParagraphWithTheGivenId()
    {
        $this->expectException(ParagraphNotFoundException::class);
        $this->expectExceptionMessage('There is no paragraph with id 5!');

        $this->databaseAdapter->setRow([]);

        $this->repository->getParagraph(5);
    }

    public function testGetParagraphReturnsTheCorrectData()
    {
        $this->assertEquals(
            (new Paragraph())
                ->setId(5)
                ->setNumberInChapter(2)
                ->setVerseNumberInChapterOffset(89432)
                ->setHeading('Die Kuh macht muh')
                ->setChapterId(2)
                ->setBookId(1),
            $this->repository->getParagraph(5)
        );
    }
}
