<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphJsonPresenter;

class EditParagraphJsonPresenterStub extends EditParagraphJsonPresenter
{
    private string $jsonString = '';
    private array $getJsonStringCalls = [];

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    /**
     * @return array<Verse>
     */
    public function getResultVerses(): array
    {
        return $this->resultVerses;
    }

    public function setJsonString(string $jsonString): EditParagraphJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(bool $resultVersesInResponse): string
    {
        $this->getJsonStringCalls[] = [$resultVersesInResponse];

        return $this->jsonString;
    }

    public function getGetJsonStringCalls(): array
    {
        return $this->getJsonStringCalls;
    }
}
