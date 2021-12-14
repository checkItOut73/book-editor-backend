<?php declare(strict_types = 1);

namespace Tests\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\EditParagraph\EditParagraphRequestHandler;
use App\BookEditorBundle\Exception\BadRequestException;

class EditParagraphRequestHandlerStub extends EditParagraphRequestHandler
{
    private array $getParagraphEntityCalls = [];
    private Paragraph $paragraphEntity;

    public function __construct()
    {
        // stub overrides constructor so that it can be instantiated without dependencies
    }

    public function setParagraphEntity(Paragraph $paragraphEntity): EditParagraphRequestHandlerStub
    {
        $this->paragraphEntity = $paragraphEntity;

        return $this;
    }

    /**
     * @param string $jsonString
     * @return Paragraph
     * @throws BadRequestException
     */
    public function getParagraphEntityFromJsonString(string $jsonString): Paragraph
    {
        $this->getParagraphEntityCalls[] = [$jsonString];

        return $this->paragraphEntity;
    }

    public function getGetParagraphEntityCalls(): array
    {
        return $this->getParagraphEntityCalls;
    }
}
