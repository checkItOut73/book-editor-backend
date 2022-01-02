<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\EditParagraph\Repository\SetVersesRepository;

class SetVersesRepositoryStub extends SetVersesRepository
{
    /** @var array<array> $setVersesCall */
    private $setVersesCalls = [];

    /** @var array<Verse> $resultVerses */
    private $resultVerses = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param array<Verse> $resultVerses
     */
    public function setResultVerses($resultVerses)
    {
        $this->resultVerses = $resultVerses;
    }

    /**
     * @param int $paragraphId
     * @param array<Verse> $verses
     * @return array<Verse>
     */
    public function setVersesAndGetResultVerses(int $paragraphId, array $verses): array
    {
        $this->setVersesCalls[] = [$paragraphId, $verses];

        return $this->resultVerses;
    }

    public function getSetVersesCalls(): array
    {
        return $this->setVersesCalls;
    }
}
