<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepository;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepository;
use App\BookEditorBundle\UseCase\GetChapter\Repository\GetChapterRepository;

class GetChapterInteractor
{
    private GetChapterRepository $getChapterRepository;
    private GetParagraphsRepository $getParagraphsRepository;
    private GetVersesRepository $getVersesRepository;
    private GetChapterJsonPresenter $getChapterPresenter;

    public function __construct(
        GetChapterRepository $getChapterRepository,
        GetParagraphsRepository $getParagraphsRepository,
        GetVersesRepository $getVersesRepository,
        GetChapterJsonPresenter $getChapterPresenter
    ) {
        $this->getChapterRepository = $getChapterRepository;
        $this->getParagraphsRepository = $getParagraphsRepository;
        $this->getVersesRepository = $getVersesRepository;
        $this->getChapterPresenter = $getChapterPresenter;
    }

    public function execute(int $chapterId): GetChapterInteractor
    {
        $chapter = $this->getChapterRepository->getChapter($chapterId);

        $paragraphs = $this->getParagraphsRepository->getParagraphsGroupedByChapterId([
            $chapterId
        ])[$chapterId];
        $chapter->setParagraphs($paragraphs);

        $versesGroupedByParagraphId = $this->getVersesRepository->getVersesGroupedByParagraphId(
            $this->getParagraphIds($paragraphs)
        );
        $this->setVersesInParagraphs($paragraphs, $versesGroupedByParagraphId);

        $this->getChapterPresenter->setChapter($chapter);

        return $this;
    }

    /**
     * @param array<Paragraph> $paragraphs
     * @return array<int>
     */
    private function getParagraphIds(array $paragraphs): array
    {
        $paragraphIds = [];

        foreach ($paragraphs as $paragraph) {
            $paragraphIds[] = $paragraph->getId();
        }

        return $paragraphIds;
    }

    /**
     * @param array<Paragraph> $paragraphs
     * @param array<int, array<Verse>> $versesGroupedByParagraphId
     */
    private function setVersesInParagraphs($paragraphs, $versesGroupedByParagraphId)
    {
        $verseNumberInChapterOffset = 0;

        foreach ($paragraphs as $paragraph) {
            $verses = $versesGroupedByParagraphId[$paragraph->getId()];

            foreach ($verses as $verse) {
                $verse->setNumberInChapter($verse->getNumberInParagraph() + $verseNumberInChapterOffset);
            }

            $paragraph->setVerses($verses);
            $verseNumberInChapterOffset += sizeof($verses);
        }
    }
}
