<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Verse;

class EditParagraphJsonPresenter
{
    /**
     * @param array<Verse> $resultVerses
     */
    protected array $resultVerses;

    public function setResultVerses(array $resultVerses)
    {
        $this->resultVerses = $resultVerses;
    }

    public function getJsonString(bool $resultVersesInResponse): string
    {
        $data = [
            'success' => [
                'message' => 'Die Änderungen wurden erfolgreich übernommen!'
            ]
        ];

        if ($resultVersesInResponse && isset($this->resultVerses)) {
            $data['result'] = [
                'verses' => $this->getResultVersesData()
            ];
        }

        return json_encode($data);
    }

    private function getResultVersesData(): array
    {
        return array_map(function (Verse $resultVerse) {
            $verseData = [
                'id' => $resultVerse->getId()
            ];

            if (!$resultVerse->isTextNull($verseData)) {
                $verseData['text'] = $resultVerse->getText();
            }

            return $verseData;
        }, $this->resultVerses);
    }
}
