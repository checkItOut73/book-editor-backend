<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use Symfony\Component\HttpFoundation\Response;

class GetChapterJsonPresenter
{
    protected Chapter $chapter;

    public function setChapter(Chapter $chapter)
    {
        $this->chapter = $chapter;
    }

    public function getHttpStatusCode(): int
    {
        return Response::HTTP_OK;
    }

    public function getJsonString(): string
    {
        return json_encode([
            'id' => $this->chapter->getId(),
            'number' => $this->chapter->getNumber(),
            'heading' => $this->chapter->getHeading(),
            'paragraphs' => array_map([$this, 'getParagraphJsonData'], $this->chapter->getParagraphs())
        ]);
    }

    private function getParagraphJsonData(Paragraph $paragraph): array
    {
        return [
            'id' => $paragraph->getId(),
            'numberInChapter' => $paragraph->getNumberInChapter(),
            'heading' => $paragraph->getHeading(),
            'verses' => array_map([$this, 'getVerseJsonData'], $paragraph->getVerses())
        ];
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