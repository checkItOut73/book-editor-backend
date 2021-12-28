<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteVerse\Repository;

use App\BookEditorBundle\UseCase\DeleteVerse\Repository\DeleteVerseRepository;

class DeleteVerseRepositoryStub extends DeleteVerseRepository
{
    /** @var array<array> $deleteVerseCalls */
    private $deleteVerseCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function deleteVerse(int $verseId)
    {
        $this->deleteVerseCalls[] = [$verseId];
    }

    public function getDeleteVerseCalls(): array
    {
        return $this->deleteVerseCalls;
    }
}
