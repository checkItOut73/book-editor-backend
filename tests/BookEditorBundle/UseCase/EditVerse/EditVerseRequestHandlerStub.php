<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\EditVerse\EditVerseRequestHandler;
use App\BookEditorBundle\Exception\BadRequestException;

class EditVerseRequestHandlerStub extends EditVerseRequestHandler
{
    private array $getVerseEntityCalls = [];
    private Verse $verseEntity;

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setVerseEntity(Verse $verseEntity): EditVerseRequestHandlerStub
    {
        $this->verseEntity = $verseEntity;

        return $this;
    }

    /**
     * @param string $jsonString
     * @return Verse
     * @throws BadRequestException
     */
    public function getVerseEntityFromJsonString(string $jsonString): Verse
    {
        $this->getVerseEntityCalls[] = [$jsonString];

        return $this->verseEntity;
    }

    public function getGetVerseEntityCalls(): array
    {
        return $this->getVerseEntityCalls;
    }
}
