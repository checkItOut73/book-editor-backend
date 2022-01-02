<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\EditParagraph\EditParagraphJsonPresenter
 */
class EditParagraphJsonPresenterTest extends TestCase
{
    private $presenter;

    public function setUp(): void
    {
        $this->presenter = new EditParagraphJsonPresenter();
    }

    public function testGetJsonReturnsCorrectJson()
    {
        $this->presenter->setResultVerses([
            (new Verse())
                ->setId(43894)
                ->setText(
                    'Im Emsland steht der stärkste Baum Deutschlands: ' .
                    'Die „Tausendjährige Linde“ oder „Dicke Linde“ von Heede.'
                ),
            (new Verse())
                ->setId(43895)
        ]);

        $this->assertEquals(
            json_encode([
                'success' => [
                    'message' => 'Die Änderungen wurden erfolgreich übernommen!'
                ],
                'result' => [
                    'verses' => [
                        [
                            'id' => 43894,
                            'text' => (
                                'Im Emsland steht der stärkste Baum Deutschlands: ' .
                                'Die „Tausendjährige Linde“ oder „Dicke Linde“ von Heede.'
                            )
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

    public function testGetJsonDoesNotContainResultVersesIfCorrespondingParameterIsFalse()
    {
        $this->presenter->setResultVerses([
            (new Verse())
                ->setId(43894)
                ->setText(
                    'Im Emsland steht der stärkste Baum Deutschlands: ' .
                    'Die „Tausendjährige Linde“ oder „Dicke Linde“ von Heede.'
                ),
            (new Verse())
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

    public function testGetJsonDoesNotContainResultVersesIfNoneGiven()
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
