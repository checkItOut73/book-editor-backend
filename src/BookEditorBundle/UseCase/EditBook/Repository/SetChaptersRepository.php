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
     * @return array<Chapter>
     */
    public function setChaptersAndGetResultChapters(int $bookId, array $chapters): array
    {
        return $this->getChaptersOfResultRows($this->databaseAdapter->getRows(
            'EXEC setChapters @bookId = ' . (int)$bookId . ', ' .
            '@chaptersJson = ' . $this->databaseAdapter->quote($this->getChaptersJson($chapters))
        ));
    }

    /**
     * @param array<Chapter> $chapters
     * @return string
     */
    private function getChaptersJson(array $chapters): string
    {
        return json_encode(array_map(
            function (Chapter $chapter) {
                return [
                    'id' => ($chapter->getId() ?? null),
                    'heading' => ($chapter->getHeading() ?? null)
                ];
            },
            $chapters
        ));
    }

    /**
     * @param array $resultRows
     * @return array<Chapter>
     */
    private function getChaptersOfResultRows(array $resultRows): array
    {
        return array_map(function ($row) {
            $chapter = (new Chapter())
                ->setId((int)$row['id']);

            if (!is_null($row['heading'])) {
                $chapter->setHeading($row['heading']);
            }

            return $chapter;
        }, $resultRows);
    }
}
