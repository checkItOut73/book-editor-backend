<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\UseCase\GetBook\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\GetBookJsonPresenter;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class GetBookJsonPresenterStub extends GetBookJsonPresenter
{
    private string $jsonString = '';
    private int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }

    public function setJsonString(string $jsonString): GetBookJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }

    public function setHttpStatusCode(int $httpStatusCode): GetBookJsonPresenterStub
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
