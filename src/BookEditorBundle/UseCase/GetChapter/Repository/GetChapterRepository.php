<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter\Repository;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetChapter\Exception\ChapterNotFoundException;
use App\DataTransferBundle\DatabaseAdapter;

class GetChapterRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $chapterId
     * @return Chapter
     * @throws ChapterNotFoundException
     */
    public function getChapter(int $chapterId): Chapter
    {
        $chapterRow = $this->databaseAdapter->getRow('EXEC getChapter @chapterId = ' . $chapterId);

        if (empty($chapterRow)) {
            throw new ChapterNotFoundException('There is no chapter with id ' . $chapterId . '!');
        }

        return (new Chapter())
            ->setId((int)$chapterRow['id'])
            ->setNumber((int)$chapterRow['number'])
            ->setHeading($chapterRow['heading']);
    }
}
