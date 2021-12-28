<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditVerse\Repository\SetVerseTextRepository
 */
class SetVerseTextRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetVerseTextRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetVerseTextRepository($this->databaseAdapter);
    }

    public function testSetVerseTextPerformsTheCorrectQuery()
    {
        $this->repository->setVerseText(5, 'I\'ll tell you an amazing story...');

        $this->assertEquals(
            ['EXEC setVerseText @verseId = 5, @text = I\'ll tell you an amazing story... | quoted with 2'],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
