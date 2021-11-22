<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetContent;

use App\BookEditorBundle\UseCase\GetContent\GetContentJsonPresenter;

class GetContentJsonPresenterStub extends GetContentJsonPresenter
{
    private string $jsonString = '';

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function getChapters(): array
    {
        return $this->chapters;
    }

    public function setJsonString(string $jsonString)
    {
        $this->jsonString = $jsonString;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }
}
