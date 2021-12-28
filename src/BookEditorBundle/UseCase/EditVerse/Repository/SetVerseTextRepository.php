<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse\Repository;

use App\DataTransferBundle\DatabaseAdapter;

class SetVerseTextRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $verseId
     * @param string $verseText
     */
    public function setVerseText(int $verseId, string $verseText)
    {
        $this->databaseAdapter->executeQuery(
            'EXEC setVerseText @verseId = ' . $verseId . ', ' .
                '@text = ' . $this->databaseAdapter->quote($verseText)
        );
    }
}
