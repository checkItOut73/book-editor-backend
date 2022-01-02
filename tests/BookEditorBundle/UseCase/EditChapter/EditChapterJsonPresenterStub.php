<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\EditChapter\EditChapterJsonPresenter;

class EditChapterJsonPresenterStub extends EditChapterJsonPresenter
{
    private string $jsonString = '';
    private array $getJsonStringCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @return array<Paragraph>
     */
    public function getResultParagraphs(): array
    {
        return $this->resultParagraphs;
    }

    public function setJsonString(string $jsonString): EditChapterJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(bool $resultParagraphsInResponse): string
    {
        $this->getJsonStringCalls[] = [$resultParagraphsInResponse];

        return $this->jsonString;
    }

    public function getGetJsonStringCalls(): array
    {
        return $this->getJsonStringCalls;
    }
}
