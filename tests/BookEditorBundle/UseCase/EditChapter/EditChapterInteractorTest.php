<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditChapter;

use App\BookEditorBundle\Entity\Chapter;
use App\BookEditorBundle\Entity\Paragraph;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\EditChapter\EditChapterRequestHandlerStub;
use Tests\BookEditorBundle\UseCase\EditChapter\Repository\SetChapterHeadingRepositoryStub;
use Tests\BookEditorBundle\UseCase\EditChapter\Repository\SetParagraphsRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditChapter\EditChapterInteractor
 */
class EditChapterInteractorTest extends TestCase
{
    private EditChapterRequestHandlerStub $requestHandler;
    private SetChapterHeadingRepositoryStub $setChapterHeadingRepository;
    private SetParagraphsRepositoryStub $setParagraphsRepository;

    private EditChapterInteractor $interactor;

    public function setUp(): void
    {
        $this->requestHandler = (new EditChapterRequestHandlerStub())
            ->setChapterEntity(new Chapter());
        $this->setChapterHeadingRepository = new SetChapterHeadingRepositoryStub();
        $this->setParagraphsRepository = new SetParagraphsRepositoryStub();

        $this->interactor = new EditChapterInteractor(
            $this->requestHandler,
            $this->setChapterHeadingRepository,
            $this->setParagraphsRepository
        );
    }

    public function testExecuteCallsTheRequestHandlerCorrectly()
    {
        $this->interactor->execute(5, '{"heading":"The art of crafting"}');

        $this->assertEquals(
            [
                ['{"heading":"The art of crafting"}']
            ],
            $this->requestHandler->getGetChapterEntityCalls()
        );
    }

    public function testExecuteCallsTheSetChapterHeadingRepositoryCorrectly()
    {
        $this->requestHandler->setChapterEntity(
            (new Chapter())->setHeading('The rise of the sun')
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, 'The rise of the sun']
            ],
            $this->setChapterHeadingRepository->getSetChapterHeadingCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetChapterHeadingRepositoryIfTheHeadingIsNull()
    {
        $this->requestHandler->setChapterEntity(new Chapter());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setChapterHeadingRepository->getSetChapterHeadingCalls());
    }

    public function testExecuteCallsTheSetParagraphsRepositoryCorrectly()
    {
        $paragraphs = [
            (new Paragraph())
                ->setId(432),
            (new Paragraph())
                ->setId(5934)
                ->setHeading('Trust yourself'),
            (new Paragraph())
                ->setHeading('Don\'t hesitate')
        ];

        $this->requestHandler->setChapterEntity(
            (new Chapter())->setParagraphs($paragraphs)
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, $paragraphs]
            ],
            $this->setParagraphsRepository->getSetParagraphsCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetParagraphsRepositoryIfParagraphsAreNull()
    {
        $this->requestHandler->setChapterEntity(new Chapter());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setParagraphsRepository->getSetParagraphsCalls());
    }
}
