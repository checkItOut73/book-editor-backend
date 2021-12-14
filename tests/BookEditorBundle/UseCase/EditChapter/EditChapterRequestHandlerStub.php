<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\EditChapter\EditChapterRequestHandler;
use App\BookEditorBundle\Exception\BadRequestException;

class EditChapterRequestHandlerStub extends EditChapterRequestHandler
{
    private array $getChapterEntityCalls = [];
    private Chapter $chapterEntity;

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setChapterEntity(Chapter $chapterEntity): EditChapterRequestHandlerStub
    {
        $this->chapterEntity = $chapterEntity;

        return $this;
    }

    /**
     * @param string $jsonString
     * @return Chapter
     * @throws BadRequestException
     */
    public function getChapterEntityFromJsonString(string $jsonString): Chapter
    {
        $this->getChapterEntityCalls[] = [$jsonString];

        return $this->chapterEntity;
    }

    public function getGetChapterEntityCalls(): array
    {
        return $this->getChapterEntityCalls;
    }
}
