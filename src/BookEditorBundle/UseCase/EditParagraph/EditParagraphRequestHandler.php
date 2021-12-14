<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use Error;

class EditParagraphRequestHandler
{
    /**
     * @param string $jsonString
     * @return Paragraph
     * @throws BadRequestException
     */
    // TODO add index of verse in error messages
    public function getParagraphEntityFromJsonString(string $jsonString): Paragraph
    {
        $paragraphJson = json_decode($jsonString, true);

        if (is_null($paragraphJson)) {
            throw new BadRequestException('The given json invalid!');
        }

        $paragraph = new Paragraph();

        if (isset($paragraphJson['heading'])) {
            try {
                $paragraph->setHeading($paragraphJson['heading']);
            } catch (Error $e) {
                throw new BadRequestException('The given heading is invalid!');
            }
        }

        if (isset($paragraphJson['verses'])) {
            if (!is_array($paragraphJson['verses'])) {
                throw new BadRequestException('The verses field has to be an array!');
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
