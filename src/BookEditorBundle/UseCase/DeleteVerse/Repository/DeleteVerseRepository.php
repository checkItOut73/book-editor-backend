<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteVerse\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class DeleteVerseRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $verseId
     */
    public function deleteVerse(int $verseId)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC deleteVerse @verseId = ' . (int)$verseId
        );
    }
}
