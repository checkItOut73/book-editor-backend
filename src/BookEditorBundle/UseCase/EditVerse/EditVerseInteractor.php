<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\EditVerse\Repository\SetVerseTextRepository;

class EditVerseInteractor
{
    private EditVerseRequestHandler $requestHandler;
    private SetVerseTextRepository $setVerseTextRepository;
    private Verse $verseEntitiy;

    public function __construct(
        EditVerseRequestHandler $requestHandler,
        SetVerseTextRepository $setVerseTextRepository
    ) {
        $this->requestHandler = $requestHandler;
        $this->setVerseTextRepository = $setVerseTextRepository;
    }

    public function execute(int $verseId, string $requestContent)
    {
        $this->verseEntitiy = $this->requestHandler->getVerseEntityFromJsonString($requestContent);

        if (!$this->verseEntitiy->isTextNull()) {
            $this->setVerseTextRepository->setVerseText(
                $verseId,
                $this->verseEntitiy->getText()
            );
        }
    }
}
