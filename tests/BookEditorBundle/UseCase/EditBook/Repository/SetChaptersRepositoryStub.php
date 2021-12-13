<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository;

class SetChaptersRepositoryStub extends SetChaptersRepository
{
    /** @var array<array> $setChaptersCall */
    private $setChaptersCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param int $bookId
     * @param array<Chapter> $chapters
     */
    public function setChapters(int $bookId, array $chapters)
    {
        $this->setChaptersCalls[] = [$bookId, $chapters];
    }

    public function getSetChaptersCalls(): array
    {
        return $this->setChaptersCalls;
    }
}
