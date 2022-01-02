<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use App\DataTransferBundle\DatabaseAdapter;

class GetParagraphsRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param array<int> $chapterIds
     * @return array<int, array<Paragraph>>
     */
    public function getParagraphsGroupedByChapterId(array $chapterIds): array
    {
        $paragraphsList = [];

        foreach ($chapterIds as $chapterId) {
            $paragraphsList[$chapterId] = [];
        }

        foreach ($this->databaseAdapter->getRows($this->getQuery($chapterIds)) as $row) {
            $paragraphsList[$row['chapterId']][] = (new Paragraph())
                ->setId((int)$row['id'])
                ->setNumberInChapter((int)$row['numberInChapter'])
                ->setHeading($row['heading'])
                ->setChapterId((int)$row['chapterId']);
        }

        return $paragraphsList;
    }

    /**
     * @param array<int> $chapterIds
     * @return string
     */
    private function getQuery(array $chapterIds): string
    {
        $castedChapterIds = array_map(
            function ($chapterId) {
                return (int)$chapterId;
            },
            $chapterIds
        );

        return 'EXEC getParagraphs @chapterIds = \'' . implode(',', $castedChapterIds) . '\'';
    }
}
