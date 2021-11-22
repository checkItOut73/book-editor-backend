<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepository;

class GetVersesRepositoryStub extends GetVersesRepository
{
    /** @var array<Paragraph> $versesGroupedByParagraphId */
    private array $versesGroupedByParagraphId = [];

    private array $getVersesCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setVersesGroupedByParagraphId(array $versesGroupedByParagraphId)
    {
        $this->versesGroupedByParagraphId = $versesGroupedByParagraphId;
    }

    /**
     * @param array<int> $paragraphIds
     * @return array
     */
    public function getVersesGroupedByParagraphId(array $paragraphIds): array
    {
        $this->getVersesCalls[] = $paragraphIds;

        return $this->versesGroupedByParagraphId;
    }

    public function getGetVersesCalls(): array
    {
        return $this->getVersesCalls;
    }
}
