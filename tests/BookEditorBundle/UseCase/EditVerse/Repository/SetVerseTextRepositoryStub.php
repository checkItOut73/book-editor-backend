<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditVerse\Repository;

use App\BookEditorBundle\UseCase\EditVerse\Repository\SetVerseTextRepository;

class SetVerseTextRepositoryStub extends SetVerseTextRepository
{
    /** @var array<array> $setVerseTextCalls */
    private $setVerseTextCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setVerseText(int $verseId, string $verseText)
    {
        $this->setVerseTextCalls[] = [$verseId, $verseText];
    }

    public function getSetVerseTextCalls(): array
    {
        return $this->setVerseTextCalls;
    }
}
