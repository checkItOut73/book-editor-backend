<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class SetBookTitleRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $bookId
     * @param string $bookTitle
     */
    public function setBookTitle(int $bookId, string $bookTitle)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC setBookTitle @bookId = ' . (int)$bookId . ', @title = ' . $this->databaseAdapter->quote($bookTitle)
        );
    }
}
