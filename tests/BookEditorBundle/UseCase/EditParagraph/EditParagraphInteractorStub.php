<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractor;

class EditParagraphInteractorStub extends EditParagraphInteractor
{
    private $executeCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function execute(int $paragraphId, string $requestContent): EditParagraphInteractor
    {
        $this->executeCalls[] = [$paragraphId, $requestContent];

        return $this;
    }

    public function getExecuteCalls(): array
    {
        return $this->executeCalls;
    }
}
