<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetContent\Repository;

use App\BookEditorBundle\UseCase\GetContent\Repository\GetChaptersRepository;

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

    public function getChapters(): array
    {
        $this->getChaptersCalls[] = [];

        return $this->chapters;
    }

    public function getGetChaptersCalls(): array
    {
        return $this->getChaptersCalls;
    }
}
