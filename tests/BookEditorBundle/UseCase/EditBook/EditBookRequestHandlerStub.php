<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\EditBook\EditBookRequestHandler;
use App\BookEditorBundle\Exception\BadRequestException;

class EditBookRequestHandlerStub extends EditBookRequestHandler
{
    private array $getBookEntityCalls = [];
    private Book $bookEntity;

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setBookEntity(Book $bookEntity): EditBookRequestHandlerStub
    {
        $this->bookEntity = $bookEntity;

        return $this;
    }

    public function setException(BadRequestException $exception): EditBookRequestHandlerStub
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @param string $jsonString
     * @return Book
     * @throws BadRequestException
     */
    public function getBookEntityFromJsonString(string $jsonString): Book
    {
        $this->getBookEntityCalls[] = [$jsonString];

        if (isset($this->exception)) {
            throw $this->exception;
        }

        return $this->bookEntity;
    }

    public function getGetBookEntityCalls(): array
    {
        return $this->getBookEntityCalls;
    }
}
