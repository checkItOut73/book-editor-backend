<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\GetParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetParagraph\GetParagraphJsonPresenter;

class GetParagraphJsonPresenterStub extends GetParagraphJsonPresenter
{
    private string $jsonString = '';

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function getParagraph(): Paragraph
    {
        return $this->paragraph;
    }

    public function setJsonString(string $jsonString): GetParagraphJsonPresenterStub
    {
        $this->jsonString = $jsonString;

        return $this;
    }

    public function getJsonString(): string
    {
        return $this->jsonString;
    }
}
