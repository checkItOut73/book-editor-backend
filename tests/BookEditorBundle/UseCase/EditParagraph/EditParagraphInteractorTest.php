<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditParagraph;

use App\BookEditorBundle\Entity\Paragraph;
use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\EditParagraph\EditParagraphRequestHandlerStub;
use Tests\BookEditorBundle\UseCase\EditParagraph\Repository\SetParagraphHeadingRepositoryStub;
use Tests\BookEditorBundle\UseCase\EditParagraph\Repository\SetVersesRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditParagraph\EditParagraphInteractor
 */
class EditParagraphInteractorTest extends TestCase
{
    private EditParagraphRequestHandlerStub $requestHandler;
    private SetParagraphHeadingRepositoryStub $setParagraphHeadingRepository;
    private SetVersesRepositoryStub $setVersesRepository;

    private EditParagraphInteractor $interactor;

    public function setUp(): void
    {
        $this->requestHandler = (new EditParagraphRequestHandlerStub())
            ->setParagraphEntity(new Paragraph());
        $this->setParagraphHeadingRepository = new SetParagraphHeadingRepositoryStub();
        $this->setVersesRepository = new SetVersesRepositoryStub();

        $this->interactor = new EditParagraphInteractor(
            $this->requestHandler,
            $this->setParagraphHeadingRepository,
            $this->setVersesRepository
        );
    }

    public function testExecuteCallsTheRequestHandlerCorrectly()
    {
        $this->interactor->execute(5, '{"heading":"The art of crafting"}');

        $this->assertEquals(
            [
                ['{"heading":"The art of crafting"}']
            ],
            $this->requestHandler->getGetParagraphEntityCalls()
        );
    }

    public function testExecuteCallsTheSetParagraphHeadingRepositoryCorrectly()
    {
        $this->requestHandler->setParagraphEntity(
            (new Paragraph())->setHeading('The rise of the sun')
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, 'The rise of the sun']
            ],
            $this->setParagraphHeadingRepository->getSetParagraphHeadingCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetParagraphHeadingRepositoryIfTheHeadingIsNull()
    {
        $this->requestHandler->setParagraphEntity(new Paragraph());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setParagraphHeadingRepository->getSetParagraphHeadingCalls());
    }

    public function testExecuteCallsTheSetVersesRepositoryCorrectly()
    {
        $verses = [
            (new Verse())
                ->setId(432),
            (new Verse())
                ->setId(5934)
                ->setText('Trust yourself'),
            (new Verse())
                ->setText('Don\'t hesitate')
        ];

        $this->requestHandler->setParagraphEntity(
            (new Paragraph())->setVerses($verses)
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, $verses]
            ],
            $this->setVersesRepository->getSetVersesCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetVersesRepositoryIfVersesAreNull()
    {
        $this->requestHandler->setParagraphEntity(new Paragraph());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setVersesRepository->getSetVersesCalls());
    }
}
