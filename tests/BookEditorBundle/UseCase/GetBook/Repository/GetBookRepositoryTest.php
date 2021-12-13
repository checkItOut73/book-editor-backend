<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\Exception\BookNotFoundException;
use PHPUnit\Framework\TestCase;
use Tests\DataTransferBundle\DatabaseAdapterStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\Repository\GetBookRepository
 */
class GetBookRepositoryTest extends TestCase
{
    private DatabaseAdapterStub $databaseAdapter;
    private GetBookRepository $repository;

    public function setUp(): void
    {
        $this->databaseAdapter = (new DatabaseAdapterStub())
            ->setRow([
                'id' => '5',
                'title' => 'Die Kuh macht muh'
            ]);

        $this->repository = new GetBookRepository($this->databaseAdapter);
    }

    public function testGetBookPerformsTheCorrectQuery()
    {
        $this->repository->getBook(5);

        $this->assertEquals(
            ['EXEC getBook @bookId = 5'],
            $this->databaseAdapter->getGetRowCalls()
        );
    }

    public function testGetBookThrowsAnExceptionIfThereIsNoBookWithTheGivenId()
    {
        $this->expectException(BookNotFoundException::class);
        $this->expectExceptionMessage('There is no book with id 5!');

        $this->databaseAdapter->setRow([]);

        $this->repository->getBook(5);
    }

    public function testGetBookReturnsTheCorrectData()
    {
        $this->assertEquals(
            (new Book())
                ->setId(5)
                ->setTitle('Die Kuh macht muh'),
            $this->repository->getBook(5)
        );
    }
}
