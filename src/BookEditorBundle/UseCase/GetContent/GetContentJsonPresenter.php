<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetContent;

class GetContentJsonPresenter
{
    /** @var array<Chapter> $chapters */
    protected array $chapters = [];

    public function setChapters(array $chapters)
    {
        $this->chapters = $chapters;
    }

    public function getJsonString(): string
    {
        $jsonString = '[';

        $jsonString .= implode(
            ',',
            array_map(function ($chapter) {
                return json_encode([
                    'number' => $chapter->getNumber(),
                    'heading' => $chapter->getHeading(),
                    'paragraphs' => array_map(function ($paragraph) {
                        return [
                            'numberInChapter' => $paragraph->getNumberInChapter(),
                            'heading' => $paragraph->getHeading(),
                            'verses' => array_map(function ($verse) {
                                return [
                                    'numberInParagraph' => $verse->getNumberInParagraph(),
                                    'numberInChapter' => $verse->getNumberInChapter(),
                                    'text' => $verse->getText()
                                ];
                            }, $paragraph->getVerses())
                        ];
                    }, $chapter->getParagraphs())
                ]);
            }, $this->chapters)
        );

        $jsonString .= ']';

        return $jsonString;
    }
}
