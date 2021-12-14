<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\GetChapter;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use App\BookEditorBundle\UseCase\GetParagraph\GetParagraphInteractor;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\GetBook\Repository\GetVersesRepositoryStub;
use Tests\BookEditorBundle\UseCase\GetParagraph\GetParagraphJsonPresenterStub;
use Tests\BookEditorBundle\UseCase\GetParagraph\Repository\GetParagraphRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\GetParagraph\GetParagraphInteractor
 */
class GetParagraphInteractorTest extends TestCase
{
    private GetParagraphRepositoryStub $getParagraphRepository;
    private GetVersesRepositoryStub $getVersesRepository;
    private GetParagraphJsonPresenterStub $presenter;
    private GetParagraphInteractor $interactor;

    public function setUp(): void
    {
        $this->getParagraphRepository = (new GetParagraphRepositoryStub())
            ->setParagraph(new Paragraph());
        $this->getVersesRepository = (new GetVersesRepositoryStub())
            ->setVersesGroupedByParagraphId([
                67 => []
            ]);
        $this->presenter = new GetParagraphJsonPresenterStub();

        $this->interactor = new GetParagraphInteractor(
            $this->getParagraphRepository,
            $this->getVersesRepository,
            $this->presenter
        );
    }

    public function testExecuteCallsTheGetParagraphRepositoryCorrectly()
    {
        $this->interactor->execute(67);

        $this->assertEquals(
            [[67]],
            $this->getParagraphRepository->getGetParagraphCalls()
        );
    }

    public function testExecuteCallsTheGetVersesRepositoryCorrectly()
    {
        $this->interactor->execute(67);

        $this->assertEquals(
            [[67]],
            $this->getVersesRepository->getGetVersesCalls()
        );
    }

    public function testExecutePutsTheRepositoryResponseCorrectlyIntoThePresenter()
    {
        $this->getParagraphRepository->setParagraph(
            (new Paragraph())
                ->setId(67)
                ->setNumberInChapter(1)
                ->setVerseNumberInChapterOffset(32)
                ->setHeading('Der Karottensalat')
                ->setChapterId(12)
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
            ]
        ]);

        $this->interactor->execute(67);

        $this->assertEquals(
            (new Paragraph())
                ->setId(67)
                ->setNumberInChapter(1)
                ->setVerseNumberInChapterOffset(32)
                ->setHeading('Der Karottensalat')
                ->setChapterId(12)
                ->setVerses([
                    (new Verse())
                        ->setNumberInChapter(33)
                        ->setNumberInParagraph(1)
                        ->setText(
                            'Die klassischen Untersuchungsobjekte der Kunstgeschichte ' .
                            'sind europäische und vorderasiatische Werke der Malerei ' .
                            'und Grafik, Bildhauerei und Baukunst in der Zeit vom ' .
                            'frühen Mittelalter bis zur Gegenwart.'
                        )
                        ->setParagraphId(67),
                    (new Verse())
                        ->setNumberInChapter(34)
                        ->setNumberInParagraph(2)
                        ->setText(
                            'Die Architekturgeschichte ist zentraler Bestandteil ' .
                            'der Kunstgeschichte.'
                        )
                        ->setParagraphId(67),
                    (new Verse())
                        ->setNumberInChapter(35)
                        ->setNumberInParagraph(3)
                        ->setText(
                            'Seit ungefähr der zweiten Hälfte des 19. Jahrhunderts ' .
                            'werden zudem Gegenstände aus den Kirchenschätzen, ' .
                            'die sog. Kleinkunst, analysiert.'
                        )
                        ->setParagraphId(67)
                ]),
            $this->presenter->getParagraph()
        );
    }
}
