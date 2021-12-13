<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;
use App\BookEditorBundle\Entity\Chapter;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Repository\GetChaptersRepository
 */
class GetChaptersRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetChaptersRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = new DatabaseAdapterStub();
        $this->repository = new GetChaptersRepository($this->databaseAdapter);
    }

    public function testGetChaptersPerformsTheCorrectQuery()
    {
        $this->repository->getChapters(5);

        $this->assertEquals(
            ['EXEC getChapters @bookId = 5'],
            $this->databaseAdapter->getGetRowsCalls()
        );
    }

    public function testGetChaptersReturnsTheCorrectData()
    {
        $this->databaseAdapter->setRows([
            [
                'id' => '5',
                'number' => '1',
                'heading' => 'Once upon a time...'
            ],
            [
                'id' => '6',
                'number' => '2',
                'heading' => 'Somewhere or nowhere...'
            ]
        ]);

        $this->assertEquals(
            [
                (new Chapter())
                    ->setId(5)
                    ->setNumber(1)
                    ->setHeading('Once upon a time...'),
                (new Chapter())
                    ->setId(6)
                    ->setNumber(2)
                    ->setHeading('Somewhere or nowhere...')
            ],
            $this->repository->getChapters(5)
        );
    }
}
