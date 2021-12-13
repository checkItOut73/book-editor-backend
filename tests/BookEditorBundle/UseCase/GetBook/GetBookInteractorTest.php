<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetBook;

use App\BookEditorBundle\Entity\Book;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetChaptersRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetBook\GetBookJsonPresenterStub;
use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetBookRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetBook\GetBookInteractor
 */
class GetBookInteractorTest extends TestCase
{
    private GetBookRepositoryStub $getBookRepository;
    private GetChaptersRepositoryStub $getChaptersRepository;
    private GetParagraphsRepositoryStub $getParagraphsRepository;
    private GetVersesRepositoryStub $getVersesRepository;
    private GetBookJsonPresenterStub $presenter;
    private GetBookInteractor $interactor;

    public function setUp(): void
    {
        $this->getBookRepository = (new GetBookRepositoryStub())
            ->setBook(
                (new Book())
                    ->setId(5)
                    ->setTitle('Vor langer langer Zeit...')
            );
        $this->getChaptersRepository = new GetChaptersRepositoryStub();
        $this->getParagraphsRepository = new GetParagraphsRepositoryStub();
        $this->getVersesRepository = new GetVersesRepositoryStub();
        $this->presenter = new GetBookJsonPresenterStub();

        $this->interactor = new GetBookInteractor(
            $this->getBookRepository,
            $this->getChaptersRepository,
            $this->getParagraphsRepository,
            $this->getVersesRepository,
            $this->presenter
        );
    }

    public function testExecuteCallsTheGetBookRepositoryCorrectly()
    {
        $this->interactor->execute(5);

        $this->assertEquals(
            [[5]],
            $this->getBookRepository->getGetBookCalls()
        );
    }

    public function testExecuteCallsTheGetChaptersRepositoryCorrectly()
    {
        $this->interactor->execute(5);

        $this->assertEquals(
            [[5]],
            $this->getChaptersRepository->getGetChaptersCalls()
        );
    }

    public function testExecuteCallsTheGetParagraphsRepositoryCorrectly()
    {
        $this->getChaptersRepository->setChapters([
            (new Chapter())
                ->setId(23)
                ->setNumber(1)
                ->setHeading('Am Tag des Untergangs'),
            (new Chapter())
                ->setId(543)
                ->setNumber(2)
                ->setHeading('Die Drachenfeuer'),
        ]);
        $this->getParagraphsRepository->setParagraphsGroupedByChapterId([
            23 => [],
            543 => []
        ]);

        $this->interactor->execute(5);

        $this->assertEquals(
            [[23, 543]],
            $this->getParagraphsRepository->getGetParagraphsCalls()
        );
    }

    public function testExecuteCallsTheGetVersesRepositoryCorrectly()
    {
        $this->getParagraphsRepository->setParagraphsGroupedByChapterId([
            23 => [
                (new Paragraph())
                    ->setId(5)
                    ->setNumberInChapter(1)
                    ->setHeading('Montag')
                    ->setChapterId(23),
                (new Paragraph())
                    ->setId(6)
                    ->setNumberInChapter(2)
                    ->setHeading('Dienstag')
                    ->setChapterId(23),
                (new Paragraph())
                    ->setId(7)
                    ->setNumberInChapter(3)
                    ->setHeading('Mittwoch')
                    ->setChapterId(23)
            ],
            85 => [
                (new Paragraph())
                    ->setId(8)
                    ->setNumberInChapter(1)
                    ->setHeading('Donnerstag')
                    ->setChapterId(85),
                (new Paragraph())
                    ->setId(9)
                    ->setNumberInChapter(2)
                    ->setHeading('Freitag')
                    ->setChapterId(85),
            ]
        ]);
        $this->getVersesRepository->setVersesGroupedByParagraphId([
            5 => [],
            6 => [],
            7 => [],
            8 => [],
            9 => []
        ]);

        $this->interactor->execute(5);

        $this->assertEquals(
            [[5, 6, 7, 8, 9]],
            $this->getVersesRepository->getGetVersesCalls()
        );
    }

    public function testExecutePutsTheRepositoryResponseCorrectlyIntoThePresenter()
    {
        $this->getBookRepository->setBook(
            (new Book())
                ->setId(1)
                ->setTitle('A book')
        );
        $this->getChaptersRepository->setChapters([
            (new Chapter())
                ->setId(12)
                ->setNumber(1)
                ->setHeading('Der abgebissene Apfel'),
            (new Chapter())
                ->setId(54)
                ->setNumber(2)
                ->setHeading('Die verrostete Schere')
        ]);
        $this->getParagraphsRepository->setParagraphsGroupedByChapterId(
            [
                12 => [
                    (new Paragraph())
                        ->setId(67)
                        ->setNumberInChapter(1)
                        ->setHeading('Der Karottensalat')
                        ->setChapterId(12),
                    (new Paragraph())
                        ->setId(68)
                        ->setNumberInChapter(2)
                        ->setHeading('Quatsch mit Soße')
                        ->setChapterId(12),
                    (new Paragraph())
                        ->setId(69)
                        ->setNumberInChapter(3)
                        ->setHeading('Pudding mit Schokoladensoße')
                        ->setChapterId(12)
                ],
                54 => [
                    (new Paragraph())
                        ->setId(106)
                        ->setNumberInChapter(1)
                        ->setHeading('Käsekuchen ohne Käse')
                        ->setChapterId(54),
                    (new Paragraph())
                        ->setId(198)
                        ->setNumberInChapter(2)
                        ->setHeading('Paprikapüree')
                        ->setChapterId(54)
                ]
            ]
        );
        $this->getVersesRepository->setVersesGroupedByParagraphId([
            67 => [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setText(
                        'Die klassischen Untersuchungsobjekte der Kunstgeschichte sind europäische ' .
                        'und vorderasiatische Werke der Malerei und Grafik, Bildhauerei und Baukunst ' .
                        'in der Zeit vom frühen Mittelalter bis zur Gegenwart.'
                    )
                    ->setParagraphId(67),
                (new Verse())
                    ->setNumberInParagraph(2)
                    ->setText(
                        'Die Architekturgeschichte ist zentraler Bestandteil der Kunstgeschichte.'
                    )
                    ->setParagraphId(67),
                (new Verse())
                    ->setNumberInParagraph(3)
                    ->setText(
                        'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts werden zudem ' .
                        'Gegenstände aus den Kirchenschätzen, die sog. Kleinkunst, analysiert.'
                    )
                    ->setParagraphId(67)
            ],
            68 => [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setText(
                        'Die Kunst nichteuropäischer Kulturen und Länder wird außerhalb dieser Länder ' .
                        'in den jeweiligen Landeskunden (Sinologie, Arabistik, Afrikanistik etc.) ' .
                        'miterforscht oder in übergreifenden Disziplinen wie der Ethnologie.'
                    )
                    ->setParagraphId(68),
            ],
            69 => [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setText(
                        'Die Begriffe Kunstgeschichte oder Kunstwissenschaft entstanden im 19. Jahrhunderts ' .
                        'und gehen auf Johann Joachim Winckelmann (1717–1768) zurück, der in seinen Werken ' .
                        'zur Kunst der Antike erstmals genauere stilgeschichtliche Untersuchungen unternommen hat.'
                    )
                    ->setParagraphId(69),
                (new Verse())
                    ->setNumberInParagraph(2)
                    ->setText(
                        'Als erster deutscher Kunsthistoriker, der auch gemalt hat, kann wohl Joachim von Sandrart ' .
                        'genannt werden, der in seinem 1679 erschienenen theoretischen Hauptwerk über die Teutsche ' .
                        'Academie der Edlen Bau- Bild und Mahlerey-Künste erstmals über deutsche Künstler und ' .
                        'Kunststile geschrieben hat.'
                    )
                    ->setParagraphId(69),
            ],
            106 => [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setText(
                        'Von einer eigenständigen Disziplin Kunstgeschichte lässt sich erst seit dem ' .
                        '19. Jahrhundert sprechen.'
                    )
                    ->setParagraphId(106),
                (new Verse())
                    ->setNumberInParagraph(2)
                    ->setText(
                        'Bei vorhergehenden Schriften handelte es sich meist um Kunstbetrachtung und ' .
                        'biographische Beschreibungen.'
                    )
                    ->setParagraphId(106),
                (new Verse())
                    ->setNumberInParagraph(3)
                    ->setText(
                        'Die Entwicklung dorthin bereiteten Traktate verfassende und schriftstellernde ' .
                        'Künstler, Kunstschriftsteller, Philosophen und Kunstkritiker vor.'
                    )
                    ->setParagraphId(106),
            ],
            198 => [
                (new Verse())
                    ->setNumberInParagraph(1)
                    ->setText(
                        'Diese Praxis wird erst wieder in der Renaissance von einem Autor aufgegriffen, ' .
                        'der mit Leonardo da Vinci eine außerordentliche Breite des wissenschaftlichen ' .
                        'und künstlerischen Betätigungsfeldes gemein hatte: Giorgio Vasari.'
                    )
                    ->setParagraphId(198)
            ]
        ]);

        $this->interactor->execute(5);

        $this->assertEquals(
            (new Book())
                ->setId(1)
                ->setTitle('A book')
                ->setChapters([
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
                                            'Die klassischen Untersuchungsobjekte der Kunstgeschichte ' .
                                            'sind europäische und vorderasiatische Werke der Malerei ' .
                                            'und Grafik, Bildhauerei und Baukunst in der Zeit vom ' .
                                            'frühen Mittelalter bis zur Gegenwart.'
                                        )
                                        ->setParagraphId(67),
                                    (new Verse())
                                        ->setNumberInChapter(2)
                                        ->setNumberInParagraph(2)
                                        ->setText(
                                            'Die Architekturgeschichte ist zentraler Bestandteil ' .
                                            'der Kunstgeschichte.'
                                        )
                                        ->setParagraphId(67),
                                    (new Verse())
                                        ->setNumberInChapter(3)
                                        ->setNumberInParagraph(3)
                                        ->setText(
                                            'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts ' .
                                            'werden zudem Gegenstände aus den Kirchenschätzen, ' .
                                            'die sog. Kleinkunst, analysiert.'
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
                                            'Die Kunst nichteuropäischer Kulturen und Länder ' .
                                            'wird außerhalb dieser Länder in den jeweiligen ' .
                                            'Landeskunden (Sinologie, Arabistik, Afrikanistik etc.) ' .
                                            'miterforscht oder in übergreifenden Disziplinen ' .
                                            'wie der Ethnologie.'
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
                                            'Als erster deutscher Kunsthistoriker, der auch gemalt hat, kann ' .
                                            'wohl Joachim von Sandrart genannt werden, der in seinem 1679 ' .
                                            'erschienenen theoretischen Hauptwerk über die Teutsche ' .
                                            'Academie der Edlen Bau- Bild und Mahlerey-Künste erstmals über ' .
                                            'deutsche Künstler und Kunststile geschrieben hat.'
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
                                            'Von einer eigenständigen Disziplin Kunstgeschichte lässt ' .
                                            'sich erst seit dem 19. Jahrhundert sprechen.'
                                        )
                                        ->setParagraphId(106),
                                    (new Verse())
                                        ->setNumberInChapter(2)
                                        ->setNumberInParagraph(2)
                                        ->setText(
                                            'Bei vorhergehenden Schriften handelte es sich meist um ' .
                                            'Kunstbetrachtung und biographische Beschreibungen.'
                                        )
                                        ->setParagraphId(106),
                                    (new Verse())
                                        ->setNumberInChapter(3)
                                        ->setNumberInParagraph(3)
                                        ->setText(
                                            'Die Entwicklung dorthin bereiteten Traktate verfassende und ' .
                                            'schriftstellernde Künstler, Kunstschriftsteller, Philosophen ' .
                                            'und Kunstkritiker vor.'
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
                                            'Diese Praxis wird erst wieder in der Renaissance von einem Autor ' .
                                            'aufgegriffen, der mit Leonardo da Vinci eine außerordentliche ' .
                                            'Breite des wissenschaftlichen und künstlerischen Betätigungsfeldes ' .
                                            'gemein hatte: Giorgio Vasari.'
                                        )
                                        ->setParagraphId(198)
                                ])
                        ])
                ]),
            $this->presenter->getBook()
        );
    }
}
