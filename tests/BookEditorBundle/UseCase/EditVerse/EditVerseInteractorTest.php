<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\EditVerse;

use App\BookEditorBundle\Entity\Verse;
use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\EditVerse\EditVerseRequestHandlerStub;
use Tests\BookEditorBundle\UseCase\EditVerse\Repository\SetVerseTextRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\EditVerse\EditVerseInteractor
 */
class EditVerseInteractorTest extends TestCase
{
    private EditVerseRequestHandlerStub $requestHandler;
    private SetVerseTextRepositoryStub $setVerseTextRepository;

    private EditVerseInteractor $interactor;

    public function setUp(): void
    {
        $this->requestHandler = (new EditVerseRequestHandlerStub())
            ->setVerseEntity(new Verse());
        $this->setVerseTextRepository = new SetVerseTextRepositoryStub();

        $this->interactor = new EditVerseInteractor(
            $this->requestHandler,
            $this->setVerseTextRepository
        );
    }

    public function testExecuteCallsTheRequestHandlerCorrectly()
    {
        $this->interactor->execute(5, '{"text":"The art of crafting is awesome!"}');

        $this->assertEquals(
            [
                ['{"text":"The art of crafting is awesome!"}']
            ],
            $this->requestHandler->getGetVerseEntityCalls()
        );
    }

    public function testExecuteCallsTheSetVerseTextRepositoryCorrectly()
    {
        $this->requestHandler->setVerseEntity(
            (new Verse())->setText('You will see the rise of the sun.')
        );
        $this->interactor->execute(5, '{}');

        $this->assertEquals(
            [
                [5, 'You will see the rise of the sun.']
            ],
            $this->setVerseTextRepository->getSetVerseTextCalls()
        );
    }

    public function testExecuteDoesNotCallTheSetVerseTextRepositoryIfTheTextIsNull()
    {
        $this->requestHandler->setVerseEntity(new Verse());
        $this->interactor->execute(5, '{}');

        $this->assertEmpty($this->setVerseTextRepository->getSetVerseTextCalls());
    }
}
