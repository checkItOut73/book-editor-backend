<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteParagraph\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class DeleteParagraphRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $paragraphId
     */
    public function deleteParagraph(int $paragraphId)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC deleteParagraph @paragraphId = ' . (int)$paragraphId
        );
    }
}
