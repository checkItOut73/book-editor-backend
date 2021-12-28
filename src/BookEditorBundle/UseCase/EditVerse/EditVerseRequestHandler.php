<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\Exception\BadRequestException;
use App\BookEditorBundle\Entity\Verse;
use Error;

class EditVerseRequestHandler
{
    /**
     * @param string $jsonString
     * @return Verse
     * @throws BadRequestException
     */
    public function getVerseEntityFromJsonString(string $jsonString): Verse
    {
        $verseJson = json_decode($jsonString, true);

        if (is_null($verseJson)) {
            throw new BadRequestException('The given json invalid!');
        }

        $verse = new Verse();

        if (isset($verseJson['text'])) {
            try {
                $verse->setText($verseJson['text']);
            } catch (Error $e) {
                throw new BadRequestException('The given text is invalid!');
            }
        }

        return $verse;
    }
}
