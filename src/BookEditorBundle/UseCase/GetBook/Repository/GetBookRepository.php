<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\Exception\BookNotFoundException;
use App\DataTransferBundle\DatabaseAdapter;

class GetBookRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $bookId
     * @return Book
     * @throws BookNotFoundException
     */
    public function getBook(int $bookId): Book
    {
        $bookRow = $this->databaseAdapter->getRow('EXEC getBook @bookId = ' . (int)$bookId);

        if (empty($bookRow)) {
            throw new BookNotFoundException('There is no book with id ' . $bookId . '!');
        }

        return (new Book())
            ->setId((int)$bookRow['id'])
            ->setTitle($bookRow['title']);
    }
}
