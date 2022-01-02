<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\GetBookJsonPresenter;
use Symfony\Component\HttpFoundation\Response;

class GetBookJsonPresenterStub extends GetBookJsonPresenter
{
    private string $jsonString = '';

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function getBook(): Book
    {
        return $this->book;
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
}
