<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\EditBook\Repository\SetBookTitleRepository;
use App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository;
use App\BookEditorBundle\UseCase\EditBook\EditBookJsonPresenter;

class EditBookInteractor
{
    private EditBookRequestHandler $requestHandler;
    private SetBookTitleRepository $setBookTitleRepository;
    private SetChaptersRepository $setChaptersRepository;
    private EditBookJsonPresenter $editBookPresenter;
    private Book $bookEntitiy;

    public function __construct(
        EditBookRequestHandler $requestHandler,
        SetBookTitleRepository $setBookTitleRepository,
        SetChaptersRepository $setChaptersRepository,
        EditBookJsonPresenter $editBookPresenter
    ) {
        $this->requestHandler = $requestHandler;
        $this->setBookTitleRepository = $setBookTitleRepository;
        $this->setChaptersRepository = $setChaptersRepository;
        $this->editBookPresenter = $editBookPresenter;
    }

    public function execute(int $bookId, string $requestContent)
    {
        $this->bookEntitiy = $this->requestHandler->getBookEntityFromJsonString($requestContent);

        if (!$this->bookEntitiy->isTitleNull()) {
            $this->setBookTitleRepository->setBookTitle($bookId, $this->bookEntitiy->getTitle());
        }

        if (!$this->bookEntitiy->areChaptersNull()) {
            $this->editBookPresenter->setResultChapters(
                $this->setChaptersRepository->setChaptersAndGetResultChapters(
                    $bookId,
                    $this->bookEntitiy->getChapters()
                )
            );
        }

        // TODO handle nested field like paragraphs of chapters and verses of paragraphs
    }
}
