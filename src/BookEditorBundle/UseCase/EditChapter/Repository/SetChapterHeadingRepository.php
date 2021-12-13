<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class SetChapterHeadingRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $chapterId
     * @param string $chapterHeading
     */
    public function setChapterHeading(int $chapterId, string $chapterHeading)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC setChapterHeading @chapterId = ' . $chapterId . ', ' .
                '@heading = ' . $this->databaseAdapter->quote($chapterHeading)
        );
    }
}
