<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\EditParagraph\Repository\SetVersesRepository;
use App\BookEditorBundle\UseCase\EditParagraph\Repository\SetParagraphHeadingRepository;

class EditParagraphInteractor
{
    private EditParagraphRequestHandler $requestHandler;
    private SetParagraphHeadingRepository $setParagraphHeadingRepository;
    private SetVersesRepository $setVersesRepository;
    private Paragraph $paragraphEntitiy;

    public function __construct(
        EditParagraphRequestHandler $requestHandler,
        SetParagraphHeadingRepository $setParagraphHeadingRepository,
        SetVersesRepository $setVersesRepository
    ) {
        $this->requestHandler = $requestHandler;
        $this->setParagraphHeadingRepository = $setParagraphHeadingRepository;
        $this->setVersesRepository = $setVersesRepository;
    }

    public function execute(int $paragraphId, string $requestContent)
    {
        $this->paragraphEntitiy = $this->requestHandler->getParagraphEntityFromJsonString($requestContent);

        if (!$this->paragraphEntitiy->isHeadingNull()) {
            $this->setParagraphHeadingRepository->setParagraphHeading(
                $paragraphId,
                $this->paragraphEntitiy->getHeading()
            );
        }

        if (!$this->paragraphEntitiy->areVersesNull()) {
            $this->setVersesRepository->setVerses($paragraphId, $this->paragraphEntitiy->getVerses());
        }
    }
}
