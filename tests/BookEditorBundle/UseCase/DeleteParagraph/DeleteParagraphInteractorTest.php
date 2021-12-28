<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteParagraph;

use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\DeleteParagraph\Repository\DeleteParagraphRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteParagraph\DeleteParagraphInteractor
 */
class DeleteParagraphInteractorTest extends TestCase
{
    private DeleteParagraphRepositoryStub $deleteParagraphRepository;
    private DeleteParagraphInteractor $interactor;

    public function setUp(): void
    {
        $this->deleteParagraphRepository = new DeleteParagraphRepositoryStub();

        $this->interactor = new DeleteParagraphInteractor($this->deleteParagraphRepository);
    }

    public function testExecuteCallsTheDeleteParagraphRepositoryCorrectly()
    {
        $this->interactor->execute(5);

        $this->assertEquals(
            [
                [5]
            ],
            $this->deleteParagraphRepository->getDeleteParagraphCalls()
        );
    }
}
