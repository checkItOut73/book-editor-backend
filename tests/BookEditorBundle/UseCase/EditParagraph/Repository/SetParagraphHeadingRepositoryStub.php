<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\UseCase\EditParagraph\Repository\SetParagraphHeadingRepository;

class SetParagraphHeadingRepositoryStub extends SetParagraphHeadingRepository
{
    /** @var array<array> $setParagraphHeadingCalls */
    private $setParagraphHeadingCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setParagraphHeading(int $paragraphId, string $paragraphHeading)
    {
        $this->setParagraphHeadingCalls[] = [$paragraphId, $paragraphHeading];
    }

    public function getSetParagraphHeadingCalls(): array
    {
        return $this->setParagraphHeadingCalls;
    }
}
