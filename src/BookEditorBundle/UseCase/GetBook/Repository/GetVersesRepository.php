<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook\Repository;

use App\BookEditorBundle\Entity\Verse;
use App\DataTransferBundle\DatabaseAdapter;

class GetVersesRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param array<int> $paragraphIds
     * @return array
     */
    public function getVersesGroupedByParagraphId(array $paragraphIds): array
    {
        $versesList = [];

        foreach ($paragraphIds as $paragraphId) {
            $versesList[$paragraphId] = [];
        }

        foreach ($this->databaseAdapter->getRows($this->getQuery($paragraphIds)) as $row) {
            $versesList[$row['paragraphId']][] = (new Verse())
                ->setId((int)$row['id'])
                ->setNumberInParagraph((int)$row['numberInParagraph'])
                ->setText($row['text'])
                ->setParagraphId((int)$row['paragraphId']);
        }

        return $versesList;
    }

    /**
     * @param array<int> $paragraphIds
     * @return string
     */
    private function getQuery(array $paragraphIds): string
    {
        $castedParagraphIds = array_map(
            function ($paragraphId) {
                return (int)$paragraphId;
            },
            $paragraphIds
        );

        return 'EXEC getVerses @paragraphIds = \'' . implode(',', $castedParagraphIds) . '\'';
    }
}
