<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\Entity\Chapter;
use PDO;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository
 */
class SetChaptersRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private SetChaptersRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new SetChaptersRepository($this->databaseAdapter);
    }

    public function testSetChaptersAndGetResultChaptersPerformsTheCorrectQuery()
    {
        $this->repository->setChaptersAndGetResultChapters(
            5,
            [
                (new Chapter())
                    ->setId(432),
                (new Chapter())
                    ->setId(5934)
                    ->setHeading('Trust yourself'),
                (new Chapter())
                    ->setHeading('Don\'t hesitate')
            ]
        );

        $this->assertEquals(
            [
                'EXEC setChapters @bookId = 5, ' .
                '@chaptersJson = \'[{"id":432,"heading":null},{"id":5934,"heading":"Trust yourself"},' .
                '{"id":null,"heading":"Don\'t hesitate"}]\' | quoted with ' . PDO::PARAM_STR,
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetChaptersAndGetResultChaptersPassesEmptyChaptersJsonArrayIfNoChaptersAreGiven()
    {
        $this->repository->setChaptersAndGetResultChapters(
            5,
            []
        );

        $this->assertEquals(
            [
                'EXEC setChapters @bookId = 5, @chaptersJson = \'[]\' | quoted with ' . PDO::PARAM_STR
            ],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testSetChaptersAndGetResultChaptersReturnsResultChaptersCorrectly()
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
                (new Chapter())
                    ->setId(432),
                (new Chapter())
                    ->setId(5934)
                    ->setHeading('Trust yourself'),
                (new Chapter())
                    ->setId(765345)
                    ->setHeading('Don\'t hesitate')
            ],
            $this->repository->setChaptersAndGetResultChapters(
                5,
                [
                    (new Chapter())
                        ->setId(432),
                    (new Chapter())
                        ->setId(5934)
                        ->setHeading('Trust yourself'),
                    (new Chapter())
                        ->setHeading('Don\'t hesitate')
                ]
            )
        );
    }
}
