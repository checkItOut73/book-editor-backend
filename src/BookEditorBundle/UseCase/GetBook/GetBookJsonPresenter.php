<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\UseCase\GetBook\Entity\Book;
use App\BookEditorBundle\UseCase\GetBook\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetBook\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetBook\Entity\Verse;
use App\BookEditorBundle\UseCase\GetBook\Exception\BookNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class GetBookJsonPresenter
{
    protected Book $book;
    protected $exception;

    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function getHttpStatusCode(): int
    {
        if ($this->exception instanceof BookNotFoundException) {
            return Response::HTTP_NOT_FOUND;
        }

        return Response::HTTP_OK;
    }

    public function getJsonString(): string
    {
        if (isset($this->exception)) {
            return '{"errorMessage":"' . $this->exception->getMessage() . '"}';
        }

        return json_encode([
            'title' => $this->book->getTitle(),
            'chapters' => array_map([$this, 'getChapterJsonData'], $this->book->getChapters())
        ]);
    }

    private function getChapterJsonData(Chapter $chapter): array
    {
        return [
            'number' => $chapter->getNumber(),
            'heading' => $chapter->getHeading(),
            'paragraphs' => array_map([$this, 'getParagraphJsonData'], $chapter->getParagraphs())
        ];
    }

    private function getParagraphJsonData(Paragraph $paragraph): array
    {
        return [
            'numberInChapter' => $paragraph->getNumberInChapter(),
            'heading' => $paragraph->getHeading(),
            'verses' => array_map([$this, 'getVerseJsonData'], $paragraph->getVerses())
        ];
    }

    private function getVerseJsonData(Verse $verse): array
    {
        return [
            'numberInParagraph' => $verse->getNumberInParagraph(),
            'numberInChapter' => $verse->getNumberInChapter(),
            'text' => $verse->getText()
        ];
    }
}
