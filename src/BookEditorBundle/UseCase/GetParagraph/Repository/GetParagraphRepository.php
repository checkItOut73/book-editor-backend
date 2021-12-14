<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph\Repository;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetParagraph\Exception\ParagraphNotFoundException;
use App\DataTransferBundle\DatabaseAdapter;

class GetParagraphRepository
{
    private DatabaseAdapter $databaseAdapter;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

    /**
     * @param int $paragraphId
     * @return Paragraph
     * @throws ParagraphNotFoundException
     */
    public function getParagraph(int $paragraphId): Paragraph
    {
        $paragraphRow = $this->databaseAdapter->getRow('EXEC getParagraph @paragraphId = ' . $paragraphId);

        if (empty($paragraphRow)) {
            throw new ParagraphNotFoundException('There is no paragraph with id ' . $paragraphId . '!');
        }

        return (new Paragraph())
            ->setId((int)$paragraphRow['id'])
            ->setNumberInChapter((int)$paragraphRow['numberInChapter'])
            ->setVerseNumberInChapterOffset((int)$paragraphRow['verseNumberInChapterOffset'])
            ->setHeading($paragraphRow['heading']);
    }
}
