<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\UseCase\GetBook\Repository\GetChaptersRepository;

class GetChaptersRepositoryStub extends GetChaptersRepository
{
    /** @var array<Chapter> $chapters */
    private array $chapters = [];

    private array $getChaptersCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setChapters(array $chapters)
    {
        $this->chapters = $chapters;
    }

    public function getChapters(int $bookId): array
    {
        $this->getChaptersCalls[] = [$bookId];

        return $this->chapters;
    }

    public function getGetChaptersCalls(): array
    {
        return $this->getChaptersCalls;
    }
}
