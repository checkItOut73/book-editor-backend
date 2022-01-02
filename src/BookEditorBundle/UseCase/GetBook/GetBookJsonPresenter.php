<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;

class GetBookJsonPresenter
{
    protected Book $book;

    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    public function getJsonString(): string
    {
        return json_encode([
            'id' => $this->book->getId(),
            'title' => $this->book->getTitle(),
            'chapters' => array_map([$this, 'getChapterJsonData'], $this->book->getChapters())
        ]);
    }

    private function getChapterJsonData(Chapter $chapter): array
    {
        return [
            'id' => $chapter->getId(),
            'number' => $chapter->getNumber(),
            'heading' => $chapter->getHeading(),
            'paragraphs' => array_map([$this, 'getParagraphJsonData'], $chapter->getParagraphs())
        ];
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
