<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepository
 */
class GetParagraphsRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetParagraphsRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new GetParagraphsRepository($this->databaseAdapter);
    }

    public function testGetParagraphsPerformsTheCorrectQuery()
    {
        $this->repository->getParagraphsGroupedByChapterId([1, 2, 3]);

        $this->assertEquals(
            ['EXEC getParagraphs @chapterIds = \'1,2,3\''],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testGetParagraphsReturnsTheCorrectData()
    {
        $this->databaseAdapter->setRows([
            [
                'id' => '101',
                'numberInChapter' => '1',
                'heading' => 'Once upon a time...',
                'chapterId' => '1'
            ],
            [
                'id' => '102',
                'numberInChapter' => '2',
                'heading' => 'Somewhere or nowhere...',
                'chapterId' => '1'
            ],
            [
                'id' => '103',
                'numberInChapter' => '1',
                'heading' => 'Here comes the thruth...',
                'chapterId' => '2'
            ],
            [
                'id' => '104',
                'numberInChapter' => '1',
                'heading' => '',
                'chapterId' => '3'
            ],
            [
                'id' => '105',
                'numberInChapter' => '2',
                'heading' => 'Always the same...',
                'chapterId' => '3'
            ]
        ]);

        $this->assertEquals(
            [
                1 => [
                    (new Paragraph())
                        ->setId(101)
                        ->setNumberInChapter(1)
                        ->setHeading('Once upon a time...')
                        ->setChapterId(1),
                    (new Paragraph())
                        ->setId(102)
                        ->setNumberInChapter(2)
                        ->setHeading('Somewhere or nowhere...')
                        ->setChapterId(1)
                ],
                2 => [
                    (new Paragraph())
                        ->setId(103)
                        ->setNumberInChapter(1)
                        ->setHeading('Here comes the thruth...')
                        ->setChapterId(2)
                ],
                3 => [
                    (new Paragraph())
                        ->setId(104)
                        ->setNumberInChapter(1)
                        ->setHeading('')
                        ->setChapterId(3),
                    (new Paragraph())
                        ->setId(105)
                        ->setNumberInChapter(2)
                        ->setHeading('Always the same...')
                        ->setChapterId(3)
                ],
                4 => []
            ],
            $this->repository->getParagraphsGroupedByChapterId([1, 2, 3, 4])
        );
    }
}
