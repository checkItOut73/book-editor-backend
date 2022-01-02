<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenter;

class EditBookJsonPresenterStub extends EditBookJsonPresenter
{
    private string $jsonString = '';
    private array $getJsonStringCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @return array<Chapter>
     */
    public function getResultChapters(): array
    {
        return $this->resultChapters;
    }

    public function setJsonString(string $jsonString): EditBookJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(bool $resultChaptersInResponse): string
    {
        $this->getJsonStringCalls[] = [$resultChaptersInResponse];

        return $this->jsonString;
    }

    public function getGetJsonStringCalls(): array
    {
        return $this->getJsonStringCalls;
    }
}
