<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;

class GetParagraphJsonPresenter
{
    protected Paragraph $paragraph;

    public function setParagraph(Paragraph $paragraph)
    {
        $this->paragraph = $paragraph;
    }

    public function getJsonString(): string
    {
        return json_encode([
            'id' => $this->paragraph->getId(),
            'numberInChapter' => $this->paragraph->getNumberInChapter(),
            'heading' => $this->paragraph->getHeading(),
            'verses' => array_map([$this, 'getVerseJsonData'], $this->paragraph->getVerses()),
            'chapterId' => $this->paragraph->getChapterId(),
            'bookId' => $this->paragraph->getBookId(),
        ]);
    }

    private function getVerseJsonData(Verse $verse): array
    {
        return [
            'id' => $verse->getId(),
            'numberInParagraph' => $verse->getNumberInParagraph(),
            'numberInChapter' => $verse->getNumberInChapter(),
            'text' => $verse->getText()
        ];
    }
}
