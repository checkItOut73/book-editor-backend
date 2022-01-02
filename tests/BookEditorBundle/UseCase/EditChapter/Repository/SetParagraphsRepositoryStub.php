<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\UseCase\EditChapter\Repository\SetParagraphsRepository;

class SetParagraphsRepositoryStub extends SetParagraphsRepository
{
    /** @var array<array> $setParagraphsCall */
    private $setParagraphsCalls = [];

    /** @var array<Paragraph> $resultParagraphs */
    private $resultParagraphs = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param array<Paragraph> $resultParagraphs
     */
    public function setResultParagraphs($resultParagraphs)
    {
        $this->resultParagraphs = $resultParagraphs;
    }

    /**
     * @param int $chapterId
     * @param array<Paragraph> $paragraphs
     * @return array<Paragraph>
     */
    public function setParagraphsAndGetResultParagraphs(int $chapterId, array $paragraphs): array
    {
        $this->setParagraphsCalls[] = [$chapterId, $paragraphs];

        return $this->resultParagraphs;
    }

    public function getSetParagraphsCalls(): array
    {
        return $this->setParagraphsCalls;
    }
}
