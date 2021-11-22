<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetContent;

use App\BookEditorBundle\UseCase\GetContent\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetContent\Repository\GetChaptersRepository;
use App\BookEditorBundle\UseCase\GetContent\Repository\GetParagraphsRepository;
use App\BookEditorBundle\UseCase\GetContent\Repository\GetVersesRepository;

class GetContentInteractor
{
    private GetChaptersRepository $getChaptersRepository;
    private GetParagraphsRepository $getParagraphsRepository;
    private GetVersesRepository $getVersesRepository;
    private GetContentJsonPresenter $getContentPresenter;

    public function __construct(
        GetChaptersRepository $getChaptersRepository,
        GetParagraphsRepository $getParagraphsRepository,
        GetVersesRepository $getVersesRepository,
        GetContentJsonPresenter $getContentPresenter
    ) {
        $this->getChaptersRepository = $getChaptersRepository;
        $this->getParagraphsRepository = $getParagraphsRepository;
        $this->getVersesRepository = $getVersesRepository;
        $this->getContentPresenter = $getContentPresenter;
    }

    public function execute(): GetContentInteractor
    {
        $chapters = $this->getChaptersRepository->getChapters();

        $paragraphsGroupedByChapterId = $this->getParagraphsRepository->getParagraphsGroupedByChapterId(
            $this->getChapterIds($chapters)
        );
        $this->setParagraphsInChapters($chapters, $paragraphsGroupedByChapterId);

        $versesGroupedByParagraphId = $this->getVersesRepository->getVersesGroupedByParagraphId(
            $this->getParagraphIds($paragraphsGroupedByChapterId)
        );
        $this->setVersesInParagraphs($paragraphsGroupedByChapterId, $versesGroupedByParagraphId);

        $this->getContentPresenter->setChapters($chapters);

        return $this;
    }

    /**
     * @param array<Chapter> $chapters
     * @return array<int>
     */
    private function getChapterIds(array $chapters): array
    {
        return array_map(function (Chapter $chapter) {
            return $chapter->getId();
        }, $chapters);
    }

    /**
     * @param array<Chapter> $chapters
     * @param array<int, array<Paragraph>> $paragraphsGroupedByChapterId
     */
    private function setParagraphsInChapters($chapters, $paragraphsGroupedByChapterId)
    {
        foreach ($chapters as $chapter) {
            $chapter->setParagraphs($paragraphsGroupedByChapterId[$chapter->getId()]);
        }
    }

    /**
     * @param array<int, array<Paragraph>> $paragraphsGroupedByChapterId
     * @return array<int>
     */
    private function getParagraphIds(array $paragraphsGroupedByChapterId): array
    {
        $paragraphIds = [];

        foreach ($paragraphsGroupedByChapterId as $chapterId => $paragraphs) {
            foreach ($paragraphs as $paragraph) {
                $paragraphIds[] = $paragraph->getId();
            }
        }

        return $paragraphIds;
    }

    /**
     * @param array<int, array<Paragraph>> $paragraphsGroupedByChapterId
     * @param array<int, array<Verse>> $versesGroupedByParagraphId
     */
    private function setVersesInParagraphs($paragraphsGroupedByChapterId, $versesGroupedByParagraphId)
    {
        foreach ($paragraphsGroupedByChapterId as $paragraphs) {
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
}
