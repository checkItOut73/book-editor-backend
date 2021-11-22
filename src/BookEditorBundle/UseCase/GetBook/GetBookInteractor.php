<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\UseCase\GetBook\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetBookRepository;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetChaptersRepository;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepository;
use App\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepository;
use Exception;

class GetBookInteractor
{
    private GetBookRepository $getBookRepository;
    private GetChaptersRepository $getChaptersRepository;
    private GetParagraphsRepository $getParagraphsRepository;
    private GetVersesRepository $getVersesRepository;
    private GetBookJsonPresenter $getBookPresenter;

    public function __construct(
        GetBookRepository $getBookRepository,
        GetChaptersRepository $getChaptersRepository,
        GetParagraphsRepository $getParagraphsRepository,
        GetVersesRepository $getVersesRepository,
        GetBookJsonPresenter $getBookPresenter
    ) {
        $this->getBookRepository = $getBookRepository;
        $this->getChaptersRepository = $getChaptersRepository;
        $this->getParagraphsRepository = $getParagraphsRepository;
        $this->getVersesRepository = $getVersesRepository;
        $this->getBookPresenter = $getBookPresenter;
    }

    public function execute(int $bookId): GetBookInteractor
    {
        try {
            $book = $this->getBookRepository->getBook($bookId);
        } catch (Exception $exception) {
            $this->getBookPresenter->setException($exception);
            return $this;
        }

        $chapters = $this->getChaptersRepository->getChapters($bookId);

        $paragraphsGroupedByChapterId = $this->getParagraphsRepository->getParagraphsGroupedByChapterId(
            $this->getChapterIds($chapters)
        );
        $this->setParagraphsInChapters($chapters, $paragraphsGroupedByChapterId);

        $versesGroupedByParagraphId = $this->getVersesRepository->getVersesGroupedByParagraphId(
            $this->getParagraphIds($paragraphsGroupedByChapterId)
        );
        $this->setVersesInParagraphs($paragraphsGroupedByChapterId, $versesGroupedByParagraphId);

        $this->getBookPresenter->setBook($book->setChapters($chapters));

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
