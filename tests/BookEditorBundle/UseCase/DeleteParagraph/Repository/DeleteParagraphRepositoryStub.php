<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteParagraph\Repository;

use App\BookEditorBundle\UseCase\DeleteParagraph\Repository\DeleteParagraphRepository;

class DeleteParagraphRepositoryStub extends DeleteParagraphRepository
{
    /** @var array<array> $deleteParagraphCalls */
    private $deleteParagraphCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function deleteParagraph(int $paragraphId)
    {
        $this->deleteParagraphCalls[] = [$paragraphId];
    }

    public function getDeleteParagraphCalls(): array
    {
        return $this->deleteParagraphCalls;
    }
}
