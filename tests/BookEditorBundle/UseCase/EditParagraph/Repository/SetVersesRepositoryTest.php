<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditParagraph\Repository\SetVersesRepository
 */
class SetVersesRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetVersesRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetVersesRepository($this->databaseAdapter);
    }

    public function testSetVersesPerformsTheCorrectQuery()
    {
        $this->repository->setVerses(
            5,
            [
                (new Verse())
                    ->setId(432),
                (new Verse())
                    ->setId(5934)
                    ->setText('Trust yourself'),
                (new Verse())
                    ->setText('Don\'t hesitate')
            ]
        );

        $this->assertEquals(
            [
                'DECLARE @verses VersesTable; ' .
                'INSERT @verses VALUES (432, NULL), (5934, Trust yourself | quoted with 2), ' .
                    '(NULL, Don\'t hesitate | quoted with 2); ' .
                'EXEC setVerses @paragraphId = 5, @verses = @verses;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }

    public function testSetVersesDoesNotInsertIntoTempTableIfNoVersesAreGiven()
    {
        $this->repository->setVerses(
            5,
            []
        );

        $this->assertEquals(
            [
                'DECLARE @verses VersesTable; EXEC setVerses @paragraphId = 5, @verses = @verses;',
            ],
            $this->databaseAdapter->getExecuteQueryCalls()
        );
    }
}
