<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class SetParagraphHeadingRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $paragraphId
     * @param string $paragraphHeading
     */
    public function setParagraphHeading(int $paragraphId, string $paragraphHeading)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC setParagraphHeading @paragraphId = ' . $paragraphId . ', ' .
                '@heading = ' . $this->databaseAdapter->quote($paragraphHeading)
        );
    }
}
