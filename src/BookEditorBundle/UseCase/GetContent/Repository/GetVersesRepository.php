<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetContent\Repository;

use App\BookEditorBundle\UseCase\GetContent\Entity\Verse;
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
        return 'EXEC getVerses @paragraphIds = \'' . implode(',', $paragraphIds) . '\'';
    }
}
