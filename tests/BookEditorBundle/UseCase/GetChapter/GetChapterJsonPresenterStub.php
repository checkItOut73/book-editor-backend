<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetChapter\GetChapterJsonPresenter;
use Symfony\Component\HttpFoundation\Response;

class GetChapterJsonPresenterStub extends GetChapterJsonPresenter
{
    private string $jsonString = '';
    private int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

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

    public function setHttpStatusCode(int $httpStatusCode): GetChapterJsonPresenterStub
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
