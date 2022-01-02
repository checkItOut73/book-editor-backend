<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Paragraph;

class EditChapterJsonPresenter
{
    /**
     * @param array<Paragraph> $resultParagraphs
     */
    protected array $resultParagraphs;

    public function setResultParagraphs(array $resultParagraphs)
    {
        $this->resultParagraphs = $resultParagraphs;
    }

    public function getJsonString(bool $resultParagraphsInResponse): string
    {
        $data = [
            'success' => [
                'message' => 'Die Änderungen wurden erfolgreich übernommen!'
            ]
        ];

        if ($resultParagraphsInResponse && isset($this->resultParagraphs)) {
            $data['result'] = [
                'paragraphs' => $this->getResultParagraphsData()
            ];
        }

        return json_encode($data);
    }

    private function getResultParagraphsData(): array
    {
        return array_map(function (Paragraph $resultParagraph) {
            $paragraphData = [
                'id' => $resultParagraph->getId()
            ];

            if (!$resultParagraph->isHeadingNull($paragraphData)) {
                $paragraphData['heading'] = $resultParagraph->getHeading();
            }

            return $paragraphData;
        }, $this->resultParagraphs);
    }
}
