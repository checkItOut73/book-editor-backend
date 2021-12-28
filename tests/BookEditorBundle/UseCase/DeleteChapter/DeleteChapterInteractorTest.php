<?php declare(strict_types = 1);

namespace App\BookEditorBundle\UseCase\DeleteChapter;

use PHPUnit\Framework\TestCase;
use Tests\BookEditorBundle\UseCase\DeleteChapter\Repository\DeleteChapterRepositoryStub;

/**
 * @covers \App\BookEditorBundle\UseCase\DeleteChapter\DeleteChapterInteractor
 */
class DeleteChapterInteractorTest extends TestCase
{
    private DeleteChapterRepositoryStub $deleteChapterRepository;
    private DeleteChapterInteractor $interactor;

    public function setUp(): void
    {
        $this->deleteChapterRepository = new DeleteChapterRepositoryStub();

        $this->interactor = new DeleteChapterInteractor($this->deleteChapterRepository);
    }

    public function testExecuteCallsTheDeleteChapterRepositoryCorrectly()
    {
        $this->interactor->execute(5);

        $this->assertEquals(
            [
                [5]
            ],
            $this->deleteChapterRepository->getDeleteChapterCalls()
        );
    }
}
