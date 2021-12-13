<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\UseCase\GetChapter\GetChapterInteractor;

class GetChapterInteractorStub extends GetChapterInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $chapterId): GetChapterInteractor
    {
        $this->executeCalls[] = [$chapterId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
