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
     * @return array<Verse>
     */
    public function setVersesAndGetResultVerses(int $paragraphId, array $verses): array
    {
        return $this->getVersesOfResultRows(
            $this->databaseAdapter->getRows(
                'EXEC setVerses @paragraphId = ' . (int)$paragraphId . ', ' .
                '@versesJson = ' . $this->databaseAdapter->quote($this->getVersesJson($verses))
            )
        );
    }

    /**
     * @param array<Verse> $verses
     * @return string
     */
    private function getVersesJson(array $verses): string
    {
        return json_encode(array_map(
            function (Verse $verse) {
                return [
                    'id' => ($verse->getId() ?? null),
                    'text' => ($verse->getText() ?? null)
                ];
            },
            $verses
        ));
    }

    /**
     * @param array $resultRows
     * @return array<Verse>
     */
    private function getVersesOfResultRows(array $resultRows): array
    {
        return array_map(function ($row) {
            $verse = (new Verse())
                ->setId((int)$row['id']);

            if (!is_null($row['text'])) {
                $verse->setText($row['text']);
            }

            return $verse;
        }, $resultRows);
    }
}
