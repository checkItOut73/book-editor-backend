<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository;

class SetChaptersRepositoryStub extends SetChaptersRepository
{
    /** @var array<array> $setChaptersCall */
    private $setChaptersCalls = [];

    /** @var array<Chapter> $resultChapters */
    private $resultChapters = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param array<Chapter> $resultChapters
     */
    public function setResultChapters($resultChapters)
    {
        $this->resultChapters = $resultChapters;
    }

    /**
     * @param int $bookId
     * @param array<Chapter> $chapters
     * @return array<Chapter>
     */
    public function setChaptersAndGetResultChapters(int $bookId, array $chapters): array
    {
        $this->setChaptersCalls[] = [$bookId, $chapters];

        return $this->resultChapters;
    }

    public function getSetChaptersCalls(): array
    {
        return $this->setChaptersCalls;
    }
}
