<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\EditBook\Repository\SetBookTitleRepository;
use App\BookEditorBundle\UseCase\EditBook\Repository\SetChaptersRepository;

class EditBookInteractor
{
    private EditBookRequestHandler $requestHandler;
    private SetBookTitleRepository $setBookTitleRepository;
    private SetChaptersRepository $setChaptersRepository;
    private Book $bookEntitiy;

    public function __construct(
        EditBookRequestHandler $requestHandler,
        SetBookTitleRepository $setBookTitleRepository,
        SetChaptersRepository $setChaptersRepository
    ) {
        $this->requestHandler = $requestHandler;
        $this->setBookTitleRepository = $setBookTitleRepository;
        $this->setChaptersRepository = $setChaptersRepository;
    }

    public function execute(int $bookId, string $requestContent)
    {
        $this->bookEntitiy = $this->requestHandler->getBookEntityFromJsonString($requestContent);

        if (!$this->bookEntitiy->isTitleNull()) {
            $this->setBookTitleRepository->setBookTitle($bookId, $this->bookEntitiy->getTitle());
        }

        if (!$this->bookEntitiy->areChaptersNull()) {
            $this->setChaptersRepository->setChapters($bookId, $this->bookEntitiy->getChapters());
        }

        // TODO handle nested field like paragraphs of chapters and verses of paragraphs
    }
}
