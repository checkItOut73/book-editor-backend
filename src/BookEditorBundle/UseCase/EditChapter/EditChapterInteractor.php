<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\EditChapter\Repository\SetParagraphsRepository;
use App\BookEditorBundle\UseCase\EditChapter\Repository\SetChapterHeadingRepository;

class EditChapterInteractor
{
    private EditChapterRequestHandler $requestHandler;
    private SetChapterHeadingRepository $setChapterHeadingRepository;
    private SetParagraphsRepository $setParagraphsRepository;
    private EditChapterJsonPresenter $editChapterPresenter;
    private Chapter $chapterEntitiy;

    public function __construct(
        EditChapterRequestHandler $requestHandler,
        SetChapterHeadingRepository $setChapterHeadingRepository,
        SetParagraphsRepository $setParagraphsRepository,
        EditChapterJsonPresenter $editChapterPresenter
    ) {
        $this->requestHandler = $requestHandler;
        $this->setChapterHeadingRepository = $setChapterHeadingRepository;
        $this->setParagraphsRepository = $setParagraphsRepository;
        $this->editChapterPresenter = $editChapterPresenter;
    }

    public function execute(int $chapterId, string $requestContent)
    {
        $this->chapterEntitiy = $this->requestHandler->getChapterEntityFromJsonString($requestContent);

        if (!$this->chapterEntitiy->isHeadingNull()) {
            $this->setChapterHeadingRepository->setChapterHeading($chapterId, $this->chapterEntitiy->getHeading());
        }

        if (!$this->chapterEntitiy->areParagraphsNull()) {
            $this->editChapterPresenter->setResultParagraphs(
                $this->setParagraphsRepository->setParagraphsAndGetResultParagraphs(
                    $chapterId,
                    $this->chapterEntitiy->getParagraphs()
                )
            );
        }

        // TODO handle nested field like verses of paragraphs
    }
}
