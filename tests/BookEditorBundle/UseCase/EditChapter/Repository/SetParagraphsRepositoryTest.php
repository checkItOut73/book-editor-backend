<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use PDO;
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

    public function testSetParagraphsAndGetResultParagraphsPerformsTheCorrectQuery()
    {
        $this->repository->setParagraphsAndGetResultParagraphs(
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
                'EXEC setParagraphs @chapterId = 5, ' .
                '@paragraphsJson = \'[{"id":432,"heading":null},{"id":5934,"heading":"Trust yourself"},' .
                '{"id":null,"heading":"Don\'t hesitate"}]\' | quoted with ' . PDO::PARAM_STR,
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetParagraphsAndGetResultParagraphsPassesEmptyParagraphsJsonArrayIfNoParagraphsAreGiven()
    {
        $this->repository->setParagraphsAndGetResultParagraphs(
            5,
            []
        );

        $this->assertEquals(
            [
                'EXEC setParagraphs @chapterId = 5, @paragraphsJson = \'[]\' | quoted with ' . PDO::PARAM_STR
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetParagraphsAndGetResultParagraphsReturnsResultParagraphsCorrectly()
    {
        $this->databaseAdapter->setRows([
            [
                'id' => 432,
                'heading' => null
            ],
            [
                'id' => 5934,
                'heading' => 'Trust yourself'
            ],
            [
                'id' => 765345,
                'heading' => 'Don\'t hesitate'
            ]
        ]);

        $this->assertEquals(
            [
                (new Paragraph())
                    ->setId(432),
                (new Paragraph())
                    ->setId(5934)
                    ->setHeading('Trust yourself'),
                (new Paragraph())
                    ->setId(765345)
                    ->setHeading('Don\'t hesitate')
            ],
            $this->repository->setParagraphsAndGetResultParagraphs(
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
            )
        );
    }
}
