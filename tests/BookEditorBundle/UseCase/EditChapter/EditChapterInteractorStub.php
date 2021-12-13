<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\UseCase\EditChapter\EditChapterInteractor;

class EditChapterInteractorStub extends EditChapterInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $chapterId, string $requestContent): EditChapterInteractor
    {
        $this->executeCalls[] = [$chapterId, $requestContent];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
