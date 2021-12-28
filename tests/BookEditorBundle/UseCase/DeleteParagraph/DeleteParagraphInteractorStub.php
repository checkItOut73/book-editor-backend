<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\DeleteParagraph;

use App\BookEditorBundle\UseCase\DeleteParagraph\DeleteParagraphInteractor;

class DeleteParagraphInteractorStub extends DeleteParagraphInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $paragraphId): DeleteParagraphInteractor
    {
        $this->executeCalls[] = [$paragraphId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
