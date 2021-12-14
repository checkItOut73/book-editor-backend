<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook\Repository;

use App\BookEditorBundle\Entity\Chapter;
use App\DataTransferBundle\DatabaseAdapter;

class SetChaptersRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $bookId
     * @param array<Chapter> $chapters
     */
    public function setChapters(int $bookId, array $chapters)
    {
        $sqlQuery = 'DECLARE @chapters ChaptersTable; ';

        if (!empty($chapters)) {
            $sqlQuery .= 'INSERT @chapters VALUES ' . $this->getQueryValues($chapters) . '; ';
        }

        $sqlQuery .= 'EXEC setChapters @bookId = ' . $bookId . ', @chapters = @chapters;';

        $this->databaseAdapter->executeQuery($sqlQuery);
    }

    /**
     * @param array<Chapter> $chapters
     * @return string
     */
    private function getQueryValues(array $chapters): string
    {
        return implode(
            ', ',
            array_map(
                function (Chapter $chapter) {
                    return '(' .
                        ($chapter->getId() ?? 'NULL') . ', ' .
                        ($chapter->getHeading() ?
                            $this->databaseAdapter->quote($chapter->getHeading()) :
                            'NULL') .
                    ')';
                },
                $chapters
            )
        );
    }
}
