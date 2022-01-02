<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditParagraph\Repository\SetParagraphHeadingRepository
 */
class SetParagraphHeadingRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetParagraphHeadingRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetParagraphHeadingRepository($this->databaseAdapter);
    }

    public function testSetParagraphHeadingPerformsTheCorrectQuery()
    {
        $this->repository->setParagraphHeading(5, 'An amazing story...');

        $this->assertEquals(
            ['EXEC setParagraphHeading @paragraphId = 5, @heading = \'An amazing story...\' | quoted with 2'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
