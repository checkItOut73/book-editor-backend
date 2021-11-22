<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepository;

class GetParagraphsRepositoryStub extends GetParagraphsRepository
{
    /** @var array<Paragraph> $paragraphsGroupedByChapterId */
    private array $paragraphsGroupedByChapterId = [];

    private array $getParagraphsCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setParagraphsGroupedByChapterId(array $paragraphsGroupedByChapterId)
    {
        $this->paragraphsGroupedByChapterId = $paragraphsGroupedByChapterId;
    }

    /**
     * @param array<int> $chapterIds
     * @return array
     */
    public function getParagraphsGroupedByChapterId(array $chapterIds): array
    {
        $this->getParagraphsCalls[] = $chapterIds;

        return $this->paragraphsGroupedByChapterId;
    }

    public function getGetParagraphsCalls(): array
    {
        return $this->getParagraphsCalls;
    }
}
