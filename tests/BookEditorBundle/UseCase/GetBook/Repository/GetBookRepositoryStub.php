<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\UseCase\GetBook\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetBookRepository;
use Exception;

class GetBookRepositoryStub extends GetBookRepository
{
    private Book $book;
    private Exception $exception;

    private array $getBookCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setBook(Book $book): GetBookRepositoryStub
    {
        $this->book = $book;

        return $this;
    }

    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param int $bookId
     * @return Book
     * @throws Exception
     */
    public function getBook(int $bookId): Book
    {
        if (isset($this->exception)) {
            throw $this->exception;
        }

        $this->getBookCalls[] = [$bookId];

        return $this->book;
    }

    public function getGetBookCalls(): array
    {
        return $this->getBookCalls;
    }
}
