<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use App\DataTransferBundle\DatabaseAdapter;

class SetParagraphsRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $chapterId
     * @param array<Paragraph> $paragraphs
     */
    public function setParagraphs(int $chapterId, array $paragraphs)
    {
        $sqlQuery = 'DECLARE @paragraphs ParagraphsTable; ';

        if (!empty($paragraphs)) {
            $sqlQuery .= 'INSERT @paragraphs VALUES ' . $this->getQueryValues($paragraphs) . '; ';
        }

        $sqlQuery .= 'EXEC setParagraphs @chapterId = ' . $chapterId . ', @paragraphs = @paragraphs;';

        $this->databaseAdapter->executeQuery($sqlQuery);
    }

    /**
     * @param array<Paragraph> $paragraphs
     * @return string
     */
    private function getQueryValues(array $paragraphs): string
    {
        return implode(
            ', ',
            array_map(
                function (Paragraph $paragraph) {
                    return '(' .
                        ($paragraph->getId() ?? 'NULL') . ', ' .
                        ($paragraph->getHeading() ?
                            $this->databaseAdapter->quote($paragraph->getHeading()) :
                            'NULL') .
                    ')';
                },
                $paragraphs
            )
        );
    }
}
