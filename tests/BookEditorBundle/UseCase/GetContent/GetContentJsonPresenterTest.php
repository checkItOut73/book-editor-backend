<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetContent;

use App\BookEditorBundle\UseCase\GetContent\Entity\Chapter;
use App\BookEditorBundle\UseCase\GetContent\Entity\Paragraph;
use App\BookEditorBundle\UseCase\GetContent\Entity\Verse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\BookEditorBundle\UseCase\GetContent\GetContentJsonPresenter
 */
class GetContentJsonPresenterTest extends TestCase
{
    public function testGetJsonReturnsCorrectJson()
    {
        $presenter = new GetContentJsonPresenter();
        $presenter->setChapters([
            (new Chapter())
                ->setId(12)
                ->setNumber(1)
                ->setHeading('Der abgebissene Apfel')
                ->setParagraphs([
                    (new Paragraph())
                        ->setId(67)
                        ->setNumberInChapter(1)
                        ->setHeading('Der Karottensalat')
                        ->setChapterId(12)
                        ->setVerses([
                            (new Verse())
                                ->setNumberInChapter(1)
                                ->setNumberInParagraph(1)
                                ->setText(
                                    'Die klassischen Untersuchungsobjekte der Kunstgeschichte sind europäische ' .
                                    'und vorderasiatische Werke der Malerei und Grafik, Bildhauerei und Baukunst ' .
                                    'in der Zeit vom frühen Mittelalter bis zur Gegenwart.'
                                )
                                ->setParagraphId(67),
                            (new Verse())
                                ->setNumberInChapter(2)
                                ->setNumberInParagraph(2)
                                ->setText(
                                    'Die Architekturgeschichte ist zentraler Bestandteil der Kunstgeschichte.'
                                )
                                ->setParagraphId(67),
                            (new Verse())
                                ->setNumberInChapter(3)
                                ->setNumberInParagraph(3)
                                ->setText(
                                    'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts werden zudem ' .
                                    'Gegenstände aus den Kirchenschätzen, die sog. Kleinkunst, analysiert.'
                                )
                                ->setParagraphId(67)
                        ]),
                    (new Paragraph())
                        ->setId(68)
                        ->setNumberInChapter(2)
                        ->setHeading('Quatsch mit Soße')
                        ->setChapterId(12)
                        ->setVerses([
                            (new Verse())
                                ->setNumberInChapter(4)
                                ->setNumberInParagraph(1)
                                ->setText(
                                    'Die Kunst nichteuropäischer Kulturen und Länder wird außerhalb dieser Länder ' .
                                    'in den jeweiligen Landeskunden (Sinologie, Arabistik, Afrikanistik etc.) ' .
                                    'miterforscht oder in übergreifenden Disziplinen wie der Ethnologie.'
                                )
                                ->setParagraphId(68),
                        ]),
                    (new Paragraph())
                        ->setId(69)
                        ->setNumberInChapter(3)
                        ->setHeading('Pudding mit Schokoladensoße')
                        ->setChapterId(12)
                        ->setVerses([
                            (new Verse())
                                ->setNumberInChapter(5)
                                ->setNumberInParagraph(1)
                                ->setText(
                                    'Die Begriffe Kunstgeschichte oder Kunstwissenschaft entstanden im ' .
                                    '19. Jahrhunderts und gehen auf Johann Joachim Winckelmann (1717–1768) ' .
                                    'zurück, der in seinen Werken zur Kunst der Antike erstmals genauere ' .
                                    'stilgeschichtliche Untersuchungen unternommen hat.'
                                )
                                ->setParagraphId(69),
                            (new Verse())
                                ->setNumberInChapter(6)
                                ->setNumberInParagraph(2)
                                ->setText(
                                    'Als erster deutscher Kunsthistoriker, der auch gemalt hat, kann wohl ' .
                                    'Joachim von Sandrart genannt werden, der in seinem 1679 erschienenen ' .
                                    'theoretischen Hauptwerk über die Teutsche Academie der Edlen Bau- Bild ' .
                                    'und Mahlerey-Künste erstmals über deutsche Künstler und ' .
                                    'Kunststile geschrieben hat.'
                                )
                                ->setParagraphId(69),
                        ])
                ]),
            (new Chapter())
                ->setId(54)
                ->setNumber(2)
                ->setHeading('Die verrostete Schere')
                ->setParagraphs([
                    (new Paragraph())
                        ->setId(106)
                        ->setNumberInChapter(1)
                        ->setHeading('Käsekuchen ohne Käse')
                        ->setChapterId(54)
                        ->setVerses([
                            (new Verse())
                                ->setNumberInChapter(1)
                                ->setNumberInParagraph(1)
                                ->setText(
                                    'Von einer eigenständigen Disziplin Kunstgeschichte lässt sich erst seit dem ' .
                                    '19. Jahrhundert sprechen.'
                                )
                                ->setParagraphId(106),
                            (new Verse())
                                ->setNumberInChapter(2)
                                ->setNumberInParagraph(2)
                                ->setText(
                                    'Bei vorhergehenden Schriften handelte es sich meist um Kunstbetrachtung und ' .
                                    'biographische Beschreibungen.'
                                )
                                ->setParagraphId(106),
                            (new Verse())
                                ->setNumberInChapter(3)
                                ->setNumberInParagraph(3)
                                ->setText(
                                    'Die Entwicklung dorthin bereiteten Traktate verfassende und schriftstellernde ' .
                                    'Künstler, Kunstschriftsteller, Philosophen und Kunstkritiker vor.'
                                )
                                ->setParagraphId(106),
                        ]),
                    (new Paragraph())
                        ->setId(198)
                        ->setNumberInChapter(2)
                        ->setHeading('Paprikapüree')
                        ->setChapterId(54)
                        ->setVerses([
                            (new Verse())
                                ->setNumberInChapter(4)
                                ->setNumberInParagraph(1)
                                ->setText(
                                    'Diese Praxis wird erst wieder in der Renaissance von einem Autor aufgegriffen, ' .
                                    'der mit Leonardo da Vinci eine außerordentliche Breite des wissenschaftlichen ' .
                                    'und künstlerischen Betätigungsfeldes gemein hatte: Giorgio Vasari.'
                                )
                                ->setParagraphId(198)
                        ])
                ])
        ]);

        $this->assertEquals(
            json_encode([
                [
                    'number' => 1,
                    'heading' => 'Der abgebissene Apfel',
                    'paragraphs' => [
                        [
                            'numberInChapter' => 1,
                            'heading' => 'Der Karottensalat',
                            'verses' => [
                                [
                                    'numberInParagraph' => 1,
                                    'numberInChapter' => 1,
                                    'text' =>
                                        'Die klassischen Untersuchungsobjekte der Kunstgeschichte sind europäische ' .
                                        'und vorderasiatische Werke der Malerei und Grafik, Bildhauerei und Baukunst ' .
                                        'in der Zeit vom frühen Mittelalter bis zur Gegenwart.'
                                ],
                                [
                                    'numberInParagraph' => 2,
                                    'numberInChapter' => 2,
                                    'text' =>
                                        'Die Architekturgeschichte ist zentraler Bestandteil der Kunstgeschichte.'
                                ],
                                [
                                    'numberInParagraph' => 3,
                                    'numberInChapter' => 3,
                                    'text' =>
                                        'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts werden zudem ' .
                                        'Gegenstände aus den Kirchenschätzen, die sog. Kleinkunst, analysiert.'
                                ]
                            ]
                        ],
                        [
                            'numberInChapter' => 2,
                            'heading' => 'Quatsch mit Soße',
                            'verses' => [
                                [
                                    'numberInParagraph' => 1,
                                    'numberInChapter' => 4,
                                    'text' =>
                                        'Die Kunst nichteuropäischer Kulturen und Länder wird außerhalb dieser ' .
                                        'Länder in den jeweiligen Landeskunden (Sinologie, Arabistik, Afrikanistik ' .
                                        'etc.) miterforscht oder in übergreifenden Disziplinen wie der Ethnologie.'
                                ]
                            ]
                        ],
                        [
                            'numberInChapter' => 3,
                            'heading' => 'Pudding mit Schokoladensoße',
                            'verses' => [
                                [
                                    'numberInParagraph' => 1,
                                    'numberInChapter' => 5,
                                    'text' =>
                                        'Die Begriffe Kunstgeschichte oder Kunstwissenschaft entstanden ' .
                                        'im 19. Jahrhunderts und gehen auf Johann Joachim Winckelmann ' .
                                        '(1717–1768) zurück, der in seinen Werken zur Kunst der Antike ' .
                                        'erstmals genauere stilgeschichtliche Untersuchungen unternommen hat.'
                                ],
                                [
                                    'numberInParagraph' => 2,
                                    'numberInChapter' => 6,
                                    'text' =>
                                        'Als erster deutscher Kunsthistoriker, der auch gemalt hat, kann wohl ' .
                                        'Joachim von Sandrart genannt werden, der in seinem 1679 erschienenen ' .
                                        'theoretischen Hauptwerk über die Teutsche Academie der Edlen Bau- Bild ' .
                                        'und Mahlerey-Künste erstmals über deutsche Künstler und ' .
                                        'Kunststile geschrieben hat.'
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'number' => 2,
                    'heading' => 'Die verrostete Schere',
                    'paragraphs' => [
                        [
                            'numberInChapter' => 1,
                            'heading' => 'Käsekuchen ohne Käse',
                            'verses' => [
                                [
                                    'numberInParagraph' => 1,
                                    'numberInChapter' => 1,
                                    'text' =>
                                        'Von einer eigenständigen Disziplin Kunstgeschichte lässt ' .
                                        'sich erst seit dem 19. Jahrhundert sprechen.'
                                ],
                                [
                                    'numberInParagraph' => 2,
                                    'numberInChapter' => 2,
                                    'text' =>
                                        'Bei vorhergehenden Schriften handelte es sich meist um ' .
                                        'Kunstbetrachtung und biographische Beschreibungen.'
                                ],
                                [
                                    'numberInParagraph' => 3,
                                    'numberInChapter' => 3,
                                    'text' =>
                                        'Die Entwicklung dorthin bereiteten Traktate verfassende und ' .
                                        'schriftstellernde Künstler, Kunstschriftsteller, Philosophen ' .
                                        'und Kunstkritiker vor.'
                                ]
                            ]
                        ],
                        [
                            'numberInChapter' => 2,
                            'heading' => 'Paprikapüree',
                            'verses' => [
                                [
                                    'numberInParagraph' => 1,
                                    'numberInChapter' => 4,
                                    'text' =>
                                        'Diese Praxis wird erst wieder in der Renaissance von einem Autor ' .
                                        'aufgegriffen, der mit Leonardo da Vinci eine außerordentliche Breite ' .
                                        'des wissenschaftlichen und künstlerischen Betätigungsfeldes gemein ' .
                                        'hatte: Giorgio Vasari.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]),
            $presenter->getJsonString()
        );
    }
}
