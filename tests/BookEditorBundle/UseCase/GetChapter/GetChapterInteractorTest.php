<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetParagraphsRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetChapter\GetChapterJsonPresenterStub;
use Tests\BookEditorBundle\UseCase\GetChapter\Repository\GetChapterRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetChapter\GetChapterInteractor
 */
class GetChapterInteractorTest extends TestCase
{
    private GetChapterRepositoryStub $getChapterRepository;
    private GetParagraphsRepositoryStub $getParagraphsRepository;
    private GetVersesRepositoryStub $getVersesRepository;
    private GetChapterJsonPresenterStub $presenter;
    private GetChapterInteractor $interactor;

    public function setUp(): void
    {
        $this->getChapterRepository = (new GetChapterRepositoryStub())
            ->setChapter(new Chapter());
        $this->getParagraphsRepository = (new GetParagraphsRepositoryStub())
            ->setParagraphsGroupedByChapterId([12 => []]);
        $this->getVersesRepository = new GetVersesRepositoryStub();
        $this->presenter = new GetChapterJsonPresenterStub();

        $this->interactor = new GetChapterInteractor(
            $this->getChapterRepository,
            $this->getParagraphsRepository,
            $this->getVersesRepository,
            $this->presenter
        );
    }

    public function testExecuteCallsTheGetChapterRepositoryCorrectly()
    {
        $this->interactor->execute(12);

        $this->assertEquals(
            [[12]],
            $this->getChapterRepository->getGetChapterCalls()
        );
    }

    public function testExecuteCallsTheGetParagraphsRepositoryCorrectly()
    {
        $this->interactor->execute(12);

        $this->assertEquals(
            [[12]],
            $this->getParagraphsRepository->getGetParagraphsCalls()
        );
    }

    public function testExecuteCallsTheGetVersesRepositoryCorrectly()
    {
        $this->getParagraphsRepository->setParagraphsGroupedByChapterId([
            12 => [
                (new Paragraph())
                    ->setId(5)
                    ->setNumberInChapter(1)
                    ->setHeading('Montag')
                    ->setChapterId(12),
                (new Paragraph())
                    ->setId(6)
                    ->setNumberInChapter(2)
                    ->setHeading('Dienstag')
                    ->setChapterId(12),
                (new Paragraph())
                    ->setId(7)
                    ->setNumberInChapter(3)
                    ->setHeading('Mittwoch')
                    ->setChapterId(12)
            ]
        ]);
        $this->getVersesRepository->setVersesGroupedByParagraphId([
            5 => [],
            6 => [],
            7 => []
        ]);

        $this->interactor->execute(12);

        $this->assertEquals(
            [[5, 6, 7]],
            $this->getVersesRepository->getGetVersesCalls()
        );
    }

    public function testExecutePutsTheRepositoryResponseCorrectlyIntoThePresenter()
    {
        $this->getChapterRepository->setChapter(
            (new Chapter())
                ->setId(12)
                ->setNumber(1)
                ->setHeading('Der abgebissene Apfel')
        );
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
            ]
        ]);

        $this->interactor->execute(12);

        $this->assertEquals(
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
            $this->presenter->getChapter()
        );
    }
}
