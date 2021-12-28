<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteChapter\Repository;

use App\BookEditorBundle\UseCase\DeleteChapter\Repository\DeleteChapterRepository;

class DeleteChapterRepositoryStub extends DeleteChapterRepository
{
    /** @var array<array> $deleteChapterCalls */
    private $deleteChapterCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function deleteChapter(int $chapterId)
    {
        $this->deleteChapterCalls[] = [$chapterId];
    }

    public function getDeleteChapterCalls(): array
    {
        return $this->deleteChapterCalls;
    }
}
