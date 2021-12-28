<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteChapter;

use App\BookEditorBundle\UseCase\DeleteChapter\DeleteChapterInteractor;

class DeleteChapterInteractorStub extends DeleteChapterInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $chapterId): DeleteChapterInteractor
    {
        $this->executeCalls[] = [$chapterId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
