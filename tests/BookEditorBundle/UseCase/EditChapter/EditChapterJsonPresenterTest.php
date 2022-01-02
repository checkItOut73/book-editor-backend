<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Paragraph;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditChapter\EditChapterJsonPresenter
 */
class EditChapterJsonPresenterTest extends TestCase
{
    private $presenter;

    public function setUp(): void
    {
        $this->presenter = new EditChapterJsonPresenter();
    }

    public function testGetJsonReturnsCorrectJson()
    {
        $this->presenter->setResultParagraphs([
            (new Paragraph())
                ->setId(43894)
                ->setHeading('The unforgiven step'),
            (new Paragraph())
                ->setId(43895)
        ]);

        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ],
                'result' => [
                    'paragraphs' => [
                        [
                            'id' => 43894,
                            'heading' => 'The unforgiven step'
                        ],
                        [
                            'id' => 43895
                        ]
                    ]
                ]
            ]),
            $this->presenter->getJsonString(true)
        );
    }

    public function testGetJsonDoesNotContainResultParagraphsIfCorrespondingParameterIsFalse()
    {
        $this->presenter->setResultParagraphs([
            (new Paragraph())
                ->setId(43894)
                ->setHeading('The unforgiven step'),
            (new Paragraph())
                ->setId(43895)
        ]);

        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ]
            ]),
            $this->presenter->getJsonString(false)
        );
    }

    public function testGetJsonDoesNotContainResultParagraphsIfNoneGiven()
    {
        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ]
            ]),
            $this->presenter->getJsonString(true)
        );
    }
}
