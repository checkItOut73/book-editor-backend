<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditChapter\Repository\SetParagraphsRepository
 */
class SetParagraphsRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetParagraphsRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetParagraphsRepository($this->databaseAdapter);
    }

    public function testSetParagraphsPerformsTheCorrectQuery()
    {
        $this->repository->setParagraphs(
            5,
            [
                (new Paragraph())
                    ->setId(432),
                (new Paragraph())
                    ->setId(5934)
                    ->setHeading('Trust yourself'),
                (new Paragraph())
                    ->setHeading('Don\'t hesitate')
            ]
        );

        $this->assertEquals(
            [
                'DECLARE @paragraphs ParagraphsTable; ' .
                'INSERT @paragraphs VALUES (432, NULL), (5934, Trust yourself | quoted with 2), ' .
                    '(NULL, Don\'t hesitate | quoted with 2); ' .
                'EXEC setParagraphs @chapterId = 5, @paragraphs = @paragraphs;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }

    public function testSetParagraphsDoesNotInsertIntoTempTableIfNoParagraphsAreGiven()
    {
        $this->repository->setParagraphs(
            5,
            []
        );

        $this->assertEquals(
            [
                'DECLARE @paragraphs ParagraphsTable; EXEC setParagraphs @chapterId = 5, @paragraphs = @paragraphs;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
