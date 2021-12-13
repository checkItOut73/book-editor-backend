<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetChapter\Repository;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetChapter\Repository\GetChapterRepository;

class GetChapterRepositoryStub extends GetChapterRepository
{
    private Chapter $chapter;
    private array $getChapterCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setChapter(Chapter $chapter): GetChapterRepositoryStub
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getChapter(int $chapterId): Chapter
    {
        $this->getChapterCalls[] = [$chapterId];

        return $this->chapter;
    }

    public function getGetChapterCalls(): array
    {
        return $this->getChapterCalls;
    }
}
