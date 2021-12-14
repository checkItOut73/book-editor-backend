<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\BookEditorBundle\UseCase\GetParagraph\GetParagraphJsonPresenter
 */
class GetParagraphJsonPresenterTest extends TestCase
{
    private $presenter;

    public function setUp(): void
    {
        $this->presenter = new GetParagraphJsonPresenter();
    }

    public function testGetJsonReturnsCorrectJson()
    {
        $this->presenter->setParagraph(
            (new Paragraph())
                ->setId(67)
                ->setNumberInChapter(1)
                ->setHeading('Der Karottensalat')
                ->setChapterId(12)
                ->setVerses([
                    (new Verse())
                        ->setId(49826)
                        ->setNumberInChapter(1)
                        ->setNumberInParagraph(1)
                        ->setText(
                            'Die klassischen Untersuchungsobjekte der Kunstgeschichte sind ' .
                            'europäische und vorderasiatische Werke der Malerei und Grafik, ' .
                            'Bildhauerei und Baukunst in der Zeit vom frühen Mittelalter ' .
                            'bis zur Gegenwart.'
                        )
                        ->setParagraphId(67),
                    (new Verse())
                        ->setId(49827)
                        ->setNumberInChapter(2)
                        ->setNumberInParagraph(2)
                        ->setText(
                            'Die Architekturgeschichte ist zentraler Bestandteil der Kunstgeschichte.'
                        )
                        ->setParagraphId(67),
                    (new Verse())
                        ->setId(49828)
                        ->setNumberInChapter(3)
                        ->setNumberInParagraph(3)
                        ->setText(
                            'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts werden zudem ' .
                            'Gegenstände aus den Kirchenschätzen, die sog. Kleinkunst, analysiert.'
                        )
                        ->setParagraphId(67)
                ])
        );

        $this->assertEquals(
            json_encode([
                'id' => 67,
                'numberInChapter' => 1,
                'heading' => 'Der Karottensalat',
                'verses' => [
                    [
                        'id' => 49826,
                        'numberInParagraph' => 1,
                        'numberInChapter' => 1,
                        'text' =>
                            'Die klassischen Untersuchungsobjekte der Kunstgeschichte sind ' .
                            'europäische und vorderasiatische Werke der Malerei und Grafik, ' .
                            'Bildhauerei und Baukunst in der Zeit vom frühen Mittelalter ' .
                            'bis zur Gegenwart.'
                    ],
                    [
                        'id' => 49827,
                        'numberInParagraph' => 2,
                        'numberInChapter' => 2,
                        'text' =>
                            'Die Architekturgeschichte ist zentraler Bestandteil der ' .
                            'Kunstgeschichte.'
                    ],
                    [
                        'id' => 49828,
                        'numberInParagraph' => 3,
                        'numberInChapter' => 3,
                        'text' =>
                            'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts werden ' .
                            'zudem Gegenstände aus den Kirchenschätzen, die sog. ' .
                            'Kleinkunst, analysiert.'
                    ]
                ]
            ]),
            $this->presenter->getJsonString()
        );
    }

    public function testGetHttpStatusCodeReturnsOk()
    {
        $this->assertSame(Response::HTTP_OK, $this->presenter->getHttpStatusCode());
    }
}
