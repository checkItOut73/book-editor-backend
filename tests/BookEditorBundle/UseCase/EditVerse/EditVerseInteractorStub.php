<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\UseCase\EditVerse\EditVerseInteractor;

class EditVerseInteractorStub extends EditVerseInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $verseId, string $requestContent): EditVerseInteractor
    {
        $this->executeCalls[] = [$verseId, $requestContent];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
