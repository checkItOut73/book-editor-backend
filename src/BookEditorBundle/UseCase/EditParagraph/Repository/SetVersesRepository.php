<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\BookEditorBundle\Entity\Verse;
use App\DataTransferBundle\DatabaseAdapter;

class SetVersesRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $paragraphId
     * @param array<Verse> $verses
     */
    public function setVerses(int $paragraphId, array $verses)
    {
        $sqlQuery = 'DECLARE @verses VersesTable; ';

        if (!empty($verses)) {
            $sqlQuery .= 'INSERT @verses VALUES ' . $this->getQueryValues($verses) . '; ';
        }

        $sqlQuery .= 'EXEC setVerses @paragraphId = ' . $paragraphId . ', @verses = @verses;';

        $this->databaseAdapter->executeQuery($sqlQuery);
    }

    /**
     * @param array<Verses> $verses
     * @return string
     */
    private function getQueryValues(array $verses): string
    {
        return implode(
            ', ',
            array_map(
                function (Verse $verse) {
                    return '(' .
                        ($verse->getId() ?? 'NULL') . ', ' .
                        ($verse->getText() ?
                            $this->databaseAdapter->quote($verse->getText()) :
                            'NULL') .
                    ')';
                },
                $verses
            )
        );
    }
}
