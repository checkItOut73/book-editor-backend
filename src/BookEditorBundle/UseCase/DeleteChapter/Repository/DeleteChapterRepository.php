<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteChapter\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class DeleteChapterRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $chapterId
     */
    public function deleteChapter(int $chapterId)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC deleteChapter @chapterId = ' . $chapterId
        );
    }
}
