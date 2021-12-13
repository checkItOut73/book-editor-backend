<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\UseCase\EditBook\Repository\SetBookTitleRepository;

class SetBookTitleRepositoryStub extends SetBookTitleRepository
{
    /** @var array<array> $setBookTitleCalls */
    private $setBookTitleCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setBookTitle(int $bookId, string $bookTitle)
    {
        $this->setBookTitleCalls[] = [$bookId, $bookTitle];
    }

    public function getSetBookTitleCalls(): array
    {
        return $this->setBookTitleCalls;
    }
}
