<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetParagraph\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetParagraph\Repository\GetParagraphRepository;

class GetParagraphRepositoryStub extends GetParagraphRepository
{
    private Paragraph $paragraph;
    private array $getParagraphCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setParagraph(Paragraph $paragraph): GetParagraphRepositoryStub
    {
        $this->paragraph = $paragraph;

        return $this;
    }

    public function getParagraph(int $paragraphId): Paragraph
    {
        $this->getParagraphCalls[] = [$paragraphId];

        return $this->paragraph;
    }

    public function getGetParagraphCalls(): array
    {
        return $this->getParagraphCalls;
    }
}
