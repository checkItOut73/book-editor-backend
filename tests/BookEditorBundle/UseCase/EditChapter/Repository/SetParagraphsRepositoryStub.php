<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\UseCase\EditChapter\Repository\SetParagraphsRepository;

class SetParagraphsRepositoryStub extends SetParagraphsRepository
{
    /** @var array<array> $setParagraphsCall */
    private $setParagraphsCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param int $chapterId
     * @param array<Paragraph> $paragraphs
     */
    public function setParagraphs(int $chapterId, array $paragraphs)
    {
        $this->setParagraphsCalls[] = [$chapterId, $paragraphs];
    }

    public function getSetParagraphsCalls(): array
    {
        return $this->setParagraphsCalls;
    }
}
