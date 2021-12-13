<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\UseCase\EditChapter\Repository\SetChapterHeadingRepository;

class SetChapterHeadingRepositoryStub extends SetChapterHeadingRepository
{
    /** @var array<array> $setChapterHeadingCalls */
    private $setChapterHeadingCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setChapterHeading(int $chapterId, string $chapterHeading)
    {
        $this->setChapterHeadingCalls[] = [$chapterId, $chapterHeading];
    }

    public function getSetChapterHeadingCalls(): array
    {
        return $this->setChapterHeadingCalls;
    }
}
