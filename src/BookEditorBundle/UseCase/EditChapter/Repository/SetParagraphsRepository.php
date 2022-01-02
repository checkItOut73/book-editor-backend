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
     * @return array<Paragraph>
     */
    public function setParagraphsAndGetResultParagraphs(int $chapterId, array $paragraphs): array
    {
        return $this->getParagraphsOfResultRows(
                $this->databaseAdapter->getRows(
                'EXEC setParagraphs @chapterId = ' . (int)$chapterId . ', ' .
                '@paragraphsJson = ' . $this->databaseAdapter->quote($this->getParagraphsJson($paragraphs))
            )
        );
    }

    /**
     * @param array<Paragraph> $paragraphs
     * @return string
     */
    private function getParagraphsJson(array $paragraphs): string
    {
        return json_encode(array_map(
            function (Paragraph $paragraph) {
                return [
                    'id' => ($paragraph->getId() ?? null),
                    'heading' => ($paragraph->getHeading() ?? null)
                ];
            },
            $paragraphs
        ));
    }

    /**
     * @param array $resultRows
     * @return array<Paragraph>
     */
    private function getParagraphsOfResultRows(array $resultRows): array
    {
        return array_map(function ($row) {
            $paragraph = (new Paragraph())
                ->setId((int)$row['id']);

            if (!is_null($row['heading'])) {
                $paragraph->setHeading($row['heading']);
            }

            return $paragraph;
        }, $resultRows);
    }
}
