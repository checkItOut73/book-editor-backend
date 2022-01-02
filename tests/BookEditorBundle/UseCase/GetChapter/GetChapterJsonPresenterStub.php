<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetChapter\GetChapterJsonPresenter;

class GetChapterJsonPresenterStub extends GetChapterJsonPresenter
{
    private string $jsonString = '';

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function setJsonString(string $jsonString): GetChapterJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }
}
