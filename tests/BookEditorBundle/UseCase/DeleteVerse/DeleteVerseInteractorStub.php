<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteVerse;

use App\BookEditorBundle\UseCase\DeleteVerse\DeleteVerseInteractor;

class DeleteVerseInteractorStub extends DeleteVerseInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $verseId): DeleteVerseInteractor
    {
        $this->executeCalls[] = [$verseId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
