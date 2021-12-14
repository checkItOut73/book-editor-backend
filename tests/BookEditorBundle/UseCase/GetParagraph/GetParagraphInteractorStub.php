<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetParagraph;

use App\BookEditorBundle\UseCase\GetParagraph\GetParagraphInteractor;

class GetParagraphInteractorStub extends GetParagraphInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $paragraphId): GetParagraphInteractor
    {
        $this->executeCalls[] = [$paragraphId];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
