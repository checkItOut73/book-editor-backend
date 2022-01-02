<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\Entity\Verse;
use PDO;
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

    public function testSetVersesAndGetResultVersesPerformsTheCorrectQuery()
    {
        $this->repository->setVersesAndGetResultVerses(
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
                'EXEC setVerses @paragraphId = 5, ' .
                '@versesJson = \'[{"id":432,"text":null},{"id":5934,"text":"Trust yourself"},' .
                '{"id":null,"text":"Don\'t hesitate"}]\' | quoted with ' . PDO::PARAM_STR,
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetVersesAndGetResultVersesPassesEmptyVersesJsonArrayIfNoVersesAreGiven()
    {
        $this->repository->setVersesAndGetResultVerses(
            5,
            []
        );

        $this->assertEquals(
            [
                'EXEC setVerses @paragraphId = 5, @versesJson = \'[]\' | quoted with ' . PDO::PARAM_STR
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetVersesAndGetResultVersesReturnsResultVersesCorrectly()
    {
        $this->databaseAdapter->setRows([
            [
                'id' => 432,
                'text' => null
            ],
            [
                'id' => 5934,
                'text' => 'Trust yourself'
            ],
            [
                'id' => 765345,
                'text' => 'Don\'t hesitate'
            ]
        ]);

        $this->assertEquals(
            [
                (new Verse())
                    ->setId(432),
                (new Verse())
                    ->setId(5934)
                    ->setText('Trust yourself'),
                (new Verse())
                    ->setId(765345)
                    ->setText('Don\'t hesitate')
            ],
            $this->repository->setVersesAndGetResultVerses(
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
            )
        );
    }
}
