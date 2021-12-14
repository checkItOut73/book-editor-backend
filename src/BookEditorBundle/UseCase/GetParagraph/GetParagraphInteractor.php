<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph;

use App\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepository;
use App\BookEditorBundle\UseCase\GetParagraph\Repository\GetParagraphRepository;

class GetParagraphInteractor
{
    private GetParagraphRepository $getParagraphRepository;
    private GetVersesRepository $getVersesRepository;
    private GetParagraphJsonPresenter $getParagraphPresenter;

    public function __construct(
        GetParagraphRepository $getParagraphRepository,
        GetVersesRepository $getVersesRepository,
        GetParagraphJsonPresenter $getParagraphPresenter
    ) {
        $this->getParagraphRepository = $getParagraphRepository;
        $this->getVersesRepository = $getVersesRepository;
        $this->getParagraphPresenter = $getParagraphPresenter;
    }

    public function execute(int $paragraphId): GetParagraphInteractor
    {
        $paragraph = $this->getParagraphRepository->getParagraph($paragraphId);

        $verses = $this->getVersesRepository->getVersesGroupedByParagraphId([
            $paragraphId
        ])[$paragraphId];

        foreach ($verses as $verse) {
            $verse->setNumberInChapter($verse->getNumberInParagraph() + $paragraph->getVerseNumberInChapterOffset());
        }
        $paragraph->setVerses($verses);

        $this->getParagraphPresenter->setParagraph($paragraph);

        return $this;
    }
}
