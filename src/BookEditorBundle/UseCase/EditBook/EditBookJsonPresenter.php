<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Entity\Chapter;

class EditBookJsonPresenter
{
    /**
     * @param array<Chapter> $resultChapters
     */
    protected array $resultChapters;

    public function setResultChapters(array $resultChapters)
    {
        $this->resultChapters = $resultChapters;
    }

    public function getJsonString(bool $resultChaptersInResponse): string
    {
        $data = [
            'success' => [
                'message' => 'Die Änderungen wurden erfolgreich übernommen!'
            ]
        ];

        if ($resultChaptersInResponse && isset($this->resultChapters)) {
            $data['result'] = [
                'chapters' => $this->getResultChaptersData()
            ];
        }

        return json_encode($data);
    }

    private function getResultChaptersData(): array
    {
        return array_map(function (Chapter $resultChapter) {
            $chapterData = [
                'id' => $resultChapter->getId()
            ];

            if (!$resultChapter->isHeadingNull($chapterData)) {
                $chapterData['heading'] = $resultChapter->getHeading();
            }

            return $chapterData;
        }, $this->resultChapters);
    }
}
