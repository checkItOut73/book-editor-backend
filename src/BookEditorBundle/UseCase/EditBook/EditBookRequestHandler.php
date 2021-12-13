<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditBook;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Book;
use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use Error;

class EditBookRequestHandler
{
    /**
     * @param string $jsonString
     * @return Book
     * @throws BadRequestException
     */
    // TODO add index of paragraph and chapter in error messages
    public function getBookEntityFromJsonString(string $jsonString): Book
    {
        $parsedJson = json_decode($jsonString, true);

        if (is_null($parsedJson)) {
            throw new BadRequestException('The given json invalid!');
        }

        $book = new Book();

        if (isset($parsedJson['title'])) {
            try {
                $book->setTitle($parsedJson['title']);
            } catch (Error $e) {
                throw new BadRequestException('The given title is invalid!');
            }
        }

        if (isset($parsedJson['chapters'])) {
            if (!is_array($parsedJson['chapters'])) {
                throw new BadRequestException('The chapters field has to be an array!');
            }

            $book->setChapters(
                array_map([$this, 'getChapterEntityFromChapterJson'], $parsedJson['chapters'])
            );
        }

        return $book;
    }

    private function getChapterEntityFromChapterJson(array $chapterJson): Chapter
    {
        $chapter = new Chapter();

        if (isset($chapterJson['id'])) {
            try {
                $chapter->setId($chapterJson['id']);
            } catch (Error $e) {
                throw new BadRequestException('The given chapter id is invalid!');
            }
        }

        if (isset($chapterJson['heading'])) {
            try {
                $chapter->setHeading($chapterJson['heading']);
            } catch (Error $e) {
                throw new BadRequestException('The given chapter heading is invalid!');
            }
        }

        if (isset($chapterJson['paragraphs'])) {
            if (!is_array($chapterJson['paragraphs'])) {
                throw new BadRequestException('The chapter paragraphs field has to be an array!');
            }

            $chapter->setParagraphs(
                array_map([$this, 'getParagraphEntityFromParagraphJson'], $chapterJson['paragraphs'])
            );
        }

        return $chapter;
    }

    private function getParagraphEntityFromParagraphJson(array $paragraphJson)
    {
        $paragraph = new Paragraph();

        if (isset($paragraphJson['id'])) {
            try {
                $paragraph->setId($paragraphJson['id']);
            } catch (Error $e) {
                throw new BadRequestException('The given paragraph id is invalid!');
            }
        }

        if (isset($paragraphJson['heading'])) {
            try {
                $paragraph->setHeading($paragraphJson['heading']);
            } catch (Error $e) {
                throw new BadRequestException('The given paragraph heading is invalid!');
            }
        }

        if (isset($paragraphJson['verses'])) {
            if (!is_array($paragraphJson['verses'])) {
                throw new BadRequestException('The paragraph verses field has to be an array!');
            }

            $paragraph->setVerses(
                array_map([$this, 'getVerseEntityFromVerseJson'], $paragraphJson['verses'])
            );
        }

        return $paragraph;
    }

    private function getVerseEntityFromVerseJson(array $verseJson): Verse
    {
        $verse = new Verse();

        if (isset($verseJson['id'])) {
            try {
                $verse->setId($verseJson['id']);
            } catch (Error $e) {
                throw new BadRequestException('The given verse id is invalid!');
            }
        }

        if (isset($verseJson['text'])) {
            try {
                $verse->setText($verseJson['text']);
            } catch (Error $e) {
                throw new BadRequestException('The given verse text is invalid!');
            }
        }

        return $verse;
    }
}
