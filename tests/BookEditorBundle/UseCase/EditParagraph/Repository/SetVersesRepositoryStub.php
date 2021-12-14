<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\EditParagraph\Repository\SetVersesRepository;

class SetVersesRepositoryStub extends SetVersesRepository
{
    /** @var array<array> $setVersesCall */
    private $setVersesCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @param int $paragraphId
     * @param array<Verse> $verses
     */
    public function setVerses(int $paragraphId, array $verses)
    {
        $this->setVersesCalls[] = [$paragraphId, $verses];
    }

    public function getSetVersesCalls(): array
    {
        return $this->setVersesCalls;
    }
}
